(() => {
  'use strict';
  const form = document.getElementById('quote-form');
  if (!form) return;
  const field = name => form.elements.namedItem(name);
  const summary = document.getElementById('quote-errors');
  const progress = document.getElementById('quote-progress');
  const button = form.querySelector('[type=submit]');
  const allowed = {utm_source:['linkedin'],utm_medium:['paid_social'],utm_campaign:['a1_s02_quote_202611','a1_s02_quote_202612','a1_s03_quote_202611','a1_s03_quote_202612'],utm_content:['n1','n2','h1','h2']};
  const query = new URLSearchParams(location.search);
  Object.entries(allowed).forEach(([key, values]) => { const value = query.get(key); field(key).value = values.includes(value) ? value : ''; });
  if (['n2','h2'].includes(field('utm_content').value)) field('coverage_type').value = 'recurring';
  // No contact values are persisted. A local digest and reference make reload retries safe.
  let lastPayload = '';
  let busy = false;
  function schedule() {
    const type = field('coverage_type').value;
    const unknown = field('schedule_unknown').checked;
    form.querySelectorAll('[data-schedule]').forEach(group => {
      const visible = !unknown && (group.dataset.schedule.split(' ').includes(type) || type === 'unsure');
      group.hidden = !visible;
      group.querySelectorAll('input,textarea').forEach(input => { input.disabled = !visible; });
    });
  }
  field('coverage_type').addEventListener('change', schedule);
  field('schedule_unknown').addEventListener('change', schedule);
  schedule();
  function clearErrors() {
    summary.hidden = true; summary.replaceChildren();
    form.querySelectorAll('[aria-invalid]').forEach(input => input.removeAttribute('aria-invalid'));
    form.querySelectorAll('.field-error').forEach(element => { element.textContent = ''; });
  }
  function showErrors(message, errors = {}) {
    summary.replaceChildren();
    const paragraph = document.createElement('p'); paragraph.textContent = message; summary.append(paragraph);
    const list = document.createElement('ul');
    Object.entries(errors).forEach(([name, text]) => {
      const input = field(name); if (!input || !input.id) return;
      input.setAttribute('aria-invalid','true');
      const inline = document.getElementById(input.id + '-error'); if (inline) inline.textContent = text;
      const item = document.createElement('li'); const link = document.createElement('a');
      link.href = '#' + input.id; link.textContent = text; link.addEventListener('click', () => input.focus()); item.append(link); list.append(item);
    });
    if (list.childElementCount) summary.append(list);
    summary.hidden = false; summary.focus();
  }
  form.addEventListener('submit', async event => {
    event.preventDefault(); if (busy) return; clearErrors();
    const errors = {};
    const messages = {firstname:'Enter your name.',email:'Enter a valid email address so we can contact you.',company:'Enter your business or property name.',location:'Enter the property address or neighborhood, borough, and city.',coverage_type:'Choose a coverage type. You can select “Not sure yet.”',service:'Choose a service.',message:'Briefly describe the coverage you need.'};
    Object.entries(messages).forEach(([name,message]) => { if (!field(name).value.trim() || !field(name).checkValidity()) errors[name] = message; });
    if (Object.keys(errors).length) { showErrors('Please complete the required fields below.', errors); return; }
    const payload = new FormData(form);
    const canonical = new URLSearchParams([...payload.entries()].filter(([key]) => !['request_id','quote_nonce','action'].includes(key))).toString();
    if (lastPayload && canonical !== lastPayload) {
      try { field('request_id').value = [...crypto.getRandomValues(new Uint8Array(16))].map(value => value.toString(16).padStart(2,'0')).join(''); }
      catch (_) { showErrors('Please reload the page before sending a changed request, or contact A1 at (917) 828-3434.'); return; }
    }
    lastPayload = canonical;
    busy = true;
    const controls = [...form.elements].map(input => [input, input.disabled]);
    controls.forEach(([input]) => { if (input.type !== 'hidden') input.disabled = true; });
    form.setAttribute('aria-busy','true'); progress.textContent = 'Sending your request…';
    try {
      const digestBytes = await crypto.subtle.digest('SHA-256', new TextEncoder().encode(canonical));
      const digest = [...new Uint8Array(digestBytes)].map(value => value.toString(16).padStart(2,'0')).join('');
      const storageKey = 'a1-quote-pending-' + field('origin_service').value;
      const previous = JSON.parse(sessionStorage.getItem(storageKey) || 'null');
      if (previous?.digest === digest && /^[a-f0-9]{32}$/.test(previous.id)) field('request_id').value = previous.id;
      sessionStorage.setItem(storageKey,JSON.stringify({digest,id:field('request_id').value}));
    } catch (_) { /* Server fingerprint deduplication also covers fresh-page retries. */ }
    payload.set('request_id',field('request_id').value);
    const controller = new AbortController(); const timeout = setTimeout(() => controller.abort(), 30000);
    try {
      // The hidden WordPress field named "action" shadows form.action in browsers.
      const response = await fetch(form.getAttribute('action'),{method:'POST',body:payload,credentials:'same-origin',signal:controller.signal});
      const result = await response.json();
      if (!response.ok || !result.success) {
        showErrors(result.data?.message || 'We could not send your request. Your entries are still here. Please try again, or contact A1 at a1securenyc@gmail.com or (917) 828-3434.', result.data?.errors || {});
      } else if (typeof result.data?.id === 'string' && result.data.id) {
        if (result.data.redirect) {
          const destination = new URL(result.data.redirect, location.origin);
          if (destination.origin === location.origin && destination.pathname === '/linkedin-quote-thanks/') {
            location.assign(destination.href);
            return;
          }
        }
        form.hidden = true;
        const success = document.getElementById('quote-success'); success.hidden = false;
        document.getElementById('quote-reference').textContent = 'Request reference: ' + result.data.id;
        success.focus();
        const eventKey = 'a1-quote-received-' + result.data.id;
        let sent = false; try { sent = sessionStorage.getItem(eventKey) === '1'; sessionStorage.setItem(eventKey,'1'); } catch (_) { /* No contact data is stored. */ }
        if (!sent) { window.dataLayer = window.dataLayer || []; window.dataLayer.push({event:'a1_quote_received',request_id:result.data.id,service:result.data.service}); }
      } else { throw new Error('Unconfirmed receipt'); }
    } catch (_) {
      showErrors('We could not confirm whether your request was received. Your entries are still here. Please check with A1 at a1securenyc@gmail.com or (917) 828-3434 before sending again.');
    } finally { clearTimeout(timeout); busy = false; controls.forEach(([input, disabled]) => { input.disabled = disabled; }); form.removeAttribute('aria-busy'); progress.textContent = ''; }
  });
})();
