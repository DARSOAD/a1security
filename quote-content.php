<?php
// Distribution copy from canonical landings/*/copy.md, brief r4.
if (!defined('ABSPATH')) { exit; }
return json_decode(<<<'A1_COPY_JSON'
{
  "S02": {
    "sector": "venues",
    "eyebrow": "MANHATTAN VENUE SECURITY",
    "title": "Request a security quote for your Manhattan venue",
    "intro": "Tell us how security needs to fit around your private bookings and regular service. Request recurring coverage, event coverage, or both, with the hours and coordination your venue needs.",
    "scope": "A1 Security Professionals provides physical security services for bars, lounges, restaurants and nightclubs in New York City. Use this form to describe your entrance, guest access needs and coordination with your management team. The proposed scope and availability will depend on a review of your request.",
    "situations": [
      [
        "A private booking during regular service",
        "Tell us when the booking starts, which entrance guests use, and how the host and manager want to coordinate arrivals."
      ],
      [
        "Coverage for your regular schedule",
        "Share your operating days, the hours that need coverage, and the responsibilities you want to discuss."
      ],
      [
        "Planning recurring coverage for January",
        "If you are reviewing service for January 2027, include your preferred start date and any changes to hours or responsibilities."
      ]
    ],
    "about": "A1 is a New York City physical security company with a focus on Manhattan and a hospitality-minded approach. Its service offering includes nightlife venues and private events.",
    "next": "A1 will review your location, requested coverage and schedule, then follow up using the contact details you provide to clarify the scope and next steps for a quote. Sending this form does not reserve coverage. Availability, responsibilities and pricing are confirmed in the agreed proposal.",
    "alt": "Conceptual illustration of a security professional and venue host coordinating a guest's arrival at a Manhattan lounge, with diners and a private reception in the background. Fictional people and venue.",
    "caption": "Illustrated concept. Fictional people and property."
  },
  "S03": {
    "sector": "hotels",
    "eyebrow": "NYC HOTEL SECURITY",
    "title": "Request a security quote for your NYC hotel",
    "intro": "Tell us how security needs to coordinate with guest arrivals, your front desk and hotel events. Request recurring coverage, event coverage, or both, based on your property's schedule and access needs.",
    "scope": "A1 Security Professionals provides hotel security services in New York City. Use this form to describe the entrances and areas that need coverage, your event schedule, and how security should work with your front desk and operations team. The proposed scope and availability will depend on a review of your request.",
    "situations": [
      [
        "Guest arrivals and front desk coordination",
        "Share where guests arrive, the hours you want covered, and which team member would coordinate with security."
      ],
      [
        "Hotel events alongside regular operations",
        "Describe event access and timing, including any overlap with guest arrivals or other activity at the property."
      ],
      [
        "Planning recurring coverage for January",
        "If you are reviewing service for January 2027, include your preferred start date, recurring hours and coordination needs."
      ]
    ],
    "about": "A1 is a New York City physical security company with a focus on Manhattan and a hospitality-minded approach. Its hotel service offering includes access control and coordination with hotel staff.",
    "next": "A1 will review your location, requested coverage and schedule, then follow up using the contact details you provide to clarify the scope and next steps for a quote. Sending this form does not reserve coverage. Availability, responsibilities and pricing are confirmed in the agreed proposal.",
    "alt": "Conceptual illustration of a security professional introducing a guest with a suitcase to a receptionist in a New York hotel lobby. Fictional people and property.",
    "caption": "Illustrated concept. Fictional people and property."
  }
}
A1_COPY_JSON
, true);
