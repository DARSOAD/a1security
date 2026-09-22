---
trigger: always_on
description: Reglas estrictas de diseño Front-End y prevención de alucinaciones UI (Determinismo Pixel-Perfect).
---

# Reglas de Diseño Front-End (Determinismo)

Este archivo establece el "Contrato de Diseño" para garantizar un desarrollo front-end determinista y de alta fidelidad, erradicando la estética genérica de IA (AI Slop).

1. **PROHIBIDO adivinar medidas o colores:**
   Usa EXCLUSIVAMENTE las variables CSS / Tailwind de este proyecto. No uses clases de utilidad genéricas como `text-white` o `bg-zinc-900` de forma arbitraria; emplea siempre los tokens semánticos (ej: `bg-background`, `text-foreground`).

2. **Arquitectura Responsiva Determinista:**
   - Prioriza siempre CSS Grid (ej. `grid-cols-1 md:grid-cols-3`) sobre matemáticas de ancho frágiles basadas en Flexbox (`w-[calc(...)]`).
   - El Grid debe gobernar la disposición a lo largo de los puntos de ruptura estándar (`sm`, `md`, `lg`, `xl`).

3. **Viewport Móvil y Estabilidad Dimensional:**
   - Usa **siempre** `min-h-[100dvh]` en lugar de `h-screen` para evitar colapsos visuales y saltos de interfaz en navegadores móviles (como iOS Safari con sus barras de navegación dinámicas).

4. **Verificación Autónoma de Interfaz (Bucle Cibernético):**
   - Una vez que escribas o modifiques un componente UI, **DEBES** usar las herramientas MCP (Playwright o Puppeteer) para abrir el `localhost` u obtener capturas del DOM.
   - Debes inspeccionar los elementos renderizados, confirmar que el layout no colapsa y asegurar que las propiedades matemáticas coincidan de forma exacta con la especificación de diseño antes de declarar la tarea terminada.
