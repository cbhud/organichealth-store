# Light-Mode Design System Inspired by Shopify

## 1. Visual Theme & Atmosphere

This light-mode adaptation preserves the same design DNA as the original system — editorial typography, cinematic pacing, restrained accent color, pill-shaped controls, and layered depth — but translates it from a dark auditorium into a bright, gallery-like environment. The experience should feel airy, premium, and deliberate rather than flat or generic.

Instead of staging the interface against near-black surfaces, the light theme uses a hierarchy of soft whites, pale mint-tinted neutrals, and quiet sage surfaces. The goal is not "default SaaS white," but a refined, luminous canvas with just enough green atmosphere to retain the original brand character.

Typography remains the centerpiece. NeueHaasGrotesk still carries the display layer at monumental scale and unusually light weight, creating the same sense of quiet confidence. Inter Variable continues to handle the body layer with precision. The typographic mood should still feel elevated and intentional — only now it is etched in charcoal and soft black instead of glowing white.

Accent color remains tightly controlled. Shopify Neon Green (`#36F4A4`) is still the signal color, but in light mode it should appear mostly in focus rings, active indicators, and small highlights rather than broad fills. The visual restraint is what makes the accent feel premium.

**Key Characteristics:**
- Light-first design with warm white and soft mint undertones
- Ultra-light display typography at monumental scale, preserved from the original system
- Neon Green (`#36F4A4`) retained as the singular high-energy accent
- Full-pill buttons (9999px radius) remain the primary interactive shape
- Soft, layered shadows paired with subtle borders for refined depth
- White and pale-sage surfaces replacing the dark teal hierarchy
- Product imagery presented in clean, quiet containers with minimal framing
- Neutral text hierarchy built from charcoal, slate, and sage-gray tones

## 2. Color Palette & Roles

### Primary

- **Studio White** (`#FFFFFF`): Primary card surface, elevated content areas, modal surfaces
- **Soft Ivory** (`#FCFCF8`): Root page background, warm off-white foundation
- **Ink** (`#111111`): Primary text, dark UI elements, high-contrast actions

### Secondary & Accent

- **Neon Green** (`#36F4A4`): Signature accent for focus rings, active states, small highlights
- **Aloe** (`#C1FBD4`): Soft green wash for decorative backgrounds and ambient sections
- **Pistachio** (`#D4F9E0`): Light atmospheric tint for subtle section differentiation

### Surface & Background

- **Canvas** (`#FCFCF8`): Root page background
- **Mist** (`#F6FBF7`): Section background with a faint green cast
- **Sage Wash** (`#F1F7F3`): Elevated section surface, input fills, soft panels
- **Paper** (`#FFFFFF`): Primary card and modal surface
- **Card Border** (`#D9E5DD`): Quiet border for cards, panels, and controls

### Neutrals & Text

- **Ink** (`#111111`): Primary text
- **Slate** (`#374151`): Secondary headings, emphasis text
- **Muted Text** (`#4B5563`): Body support text, metadata
- **Quiet Text** (`#6B7280`): Tertiary text, timestamps, helper copy
- **Soft Divider** (`#E5E7EB`): Subtle separators and low-emphasis borders
- **Sage Divider** (`#D9E5DD`): Brand-tinted boundary for cards and containers

### Semantic & Link Tones

- **Link Ink** (`#1F2937`): Standard link color on light surfaces
- **Link Sage** (`#48635A`): Slightly green-tinted link variation
- **Link Muted** (`#667085`): Understated utility links

### Gradient System

- **Green Atmospheric Wash**: Radial gradient from `rgba(193,251,212,0.45)` to transparent for hero backgrounds
- **Soft Spotlight**: Warm white center fading into `#F6FBF7` for keynote-style presentation lighting
- **Sage Depth Wash**: Gentle gradient from `#F1F7F3` to `#FCFCF8` behind product showcases

## 3. Typography Rules

### Font Family

**Display:** NeueHaasGrotesk (refined Helvetica descendant, variable font)
- Fallbacks: Helvetica, Arial, sans-serif
- OpenType features: `ss03`
- Available weights: 330, 360, 400, 500, 750 (variable)
- Used for all headings, hero text, and large display elements

**Body:** Inter-Variable
- Fallbacks: Helvetica, Arial, sans-serif
- OpenType features: `ss03`
- Available weights: 400, 420, 450, 500, 550 (variable)
- Used for body text, links, buttons, and UI elements

**Mono:** ui-monospace
- Fallbacks: SFMono-Regular, Menlo, Monaco, Consolas, Liberation Mono, Courier New
- Used for code snippets, labels, and technical content

### Hierarchy

| Role | Size | Weight | Line Height | Letter Spacing | Notes |
|------|------|--------|-------------|----------------|-------|
| Display XL | 96px | 400 | 1.00 | — | NeueHaasGrotesk, hero headlines, `ss03` |
| Display XL Bold | 90.74px | 750 | 1.00 | 4.54px | NeueHaasGrotesk, emphasis display |
| Display XL Tracked | 96px | 400 | 1.00 | 2.4px | NeueHaasGrotesk, spaced display |
| Display Light | 96px | 330 | 0.96 | — | NeueHaasGrotesk, ethereal display |
| Heading 1 | 70px | 330 | 1.00 | — | NeueHaasGrotesk, section titles |
| Heading 2 | 55px | 330 | 1.16 | — | NeueHaasGrotesk, subsections |
| Heading 3 | 48px | 330 | 1.14 | — | NeueHaasGrotesk, feature titles |
| Heading 4 | 32px | 360 | 1.14 | 0.32px | NeueHaasGrotesk, card headings |
| Heading 5 | 28px | 500 | 1.28 | 0.42px | NeueHaasGrotesk, small headings |
| Heading 6 | 24px | 400 | 1.14 | 0.36px | NeueHaasGrotesk, minor headings |
| Body Large | 20px | 500 | 1.40 | 0.3px | NeueHaasGrotesk / Inter, lead paragraphs |
| Body | 18px | 400 | 1.56 | — | Inter-Variable, standard body |
| Body Medium | 18px | 550 | 1.56 | — | Inter-Variable, emphasized body |
| Body Small | 16px | 400 | 1.50 | — | Inter / NeueHaasGrotesk, compact body |
| Body Small Medium | 16px | 420 | 1.50 | — | Inter-Variable, slightly emphasized |
| Button | 16px | 400 | 1.50 | — | NeueHaasGrotesk, CTA text |
| Nav Link | 18px | 500 | 1.25 | 0.72px | NeueHaasGrotesk, navigation items |
| Caption | 14px | 500 | 1.49 | 0.28px | NeueHaasGrotesk / Inter, metadata |
| Caption Medium | 14px | 550 | 1.49 | 0.28px | Inter-Variable, emphasized caption |
| Overline | 15.36px | 400 | 1.50 | 1.54px | NeueHaasGrotesk, wide-tracked labels |
| Micro | 13px | 500 | 1.50 | -0.13px | Inter, tight-tracked small text |
| Label | 12px | 400 | 1.20 | 0.72px | Inter, uppercase labels |
| Code | 16px | 400 | 1.50 | — | ui-monospace, code blocks |
| Code Small | 12px | 400 | 1.33 | — | ui-monospace, inline code |

### Principles

Typography should change as little as possible from the original system. The identity is rooted in the tension between monumental scale and delicate weight. In light mode, that same feeling should remain: large headlines at weight 330-400, generous negative space, and precise body typography that feels intentionally tuned rather than default.

The emotional shift is in contrast, not structure. Where the dark theme made text feel projected in light, the light theme should make it feel printed with extraordinary precision. Body text remains compact and controlled. Headings remain feather-light. The `ss03` OpenType feature remains part of the typographic voice.

## 4. Component Stylings

### Buttons

**Primary (Dark Fill on Light)**
- Background: Ink (`#111111`)
- Text: Studio White (`#FFFFFF`)
- Border: 2px solid transparent
- Border radius: full pill (9999px)
- Padding: 12px 26px 12px 16px
- Hover: slight lift or softened fill shift toward Slate
- Focus: 2px `#36F4A4` outline ring
- Transition: all 200ms ease

**Secondary (Ghost/Outlined)**
- Background: transparent
- Text: Ink (`#111111`)
- Border: 1px solid `#D9E5DD`
- Border radius: full pill (9999px)
- Padding: 12px 26px 12px 16px
- Hover: background shifts to `#F1F7F3`
- Focus: 2px `#36F4A4` outline

**Badge/Tag (Soft Filled)**
- Background: `#F1F7F3`
- Text: Slate (`#374151`)
- Border: 1px solid `#D9E5DD`
- Border radius: 9999px or 4px depending on usage
- Padding: 8px 14px or 12px 16px
- Font: 14px-16px regular

### Cards & Containers

- Background: Paper (`#FFFFFF`)
- Border: 1px solid `#D9E5DD`
- Border radius: 8px standard, 12px featured, 20px for expressive top-rounded treatments
- Shadow: Soft layered system:
  - Resting: `rgba(17,17,17,0.04) 0px 0px 0px 1px, rgba(17,17,17,0.04) 0px 2px 4px, rgba(17,17,17,0.06) 0px 8px 24px`
  - Optional inset highlight: `rgba(255,255,255,0.8) 0px 1px 0px inset`
- Hover: slightly stronger shadow, subtle upward shift (1-2px max)
- Transition: box-shadow 300ms ease, transform 200ms ease

### Inputs & Forms

- Background: Studio White (`#FFFFFF`) or Sage Wash (`#F1F7F3`)
- Text: Ink (`#111111`)
- Border: 1px solid `#D9E5DD`
- Border radius: 8px
- Padding: 12px 16px
- Focus: 2px solid `#36F4A4`
- Placeholder: Quiet Text (`#6B7280`)
- Transition: border-color 200ms ease, box-shadow 200ms ease

### Navigation

- Background: translucent light surface over hero, becoming `rgba(252,252,248,0.9)` or `#FFFFFF` on scroll
- Height: ~64px
- Logo: dark wordmark or monochrome brand mark
- Nav links: 18px/500 NeueHaasGrotesk, Ink text, 0.72px letter-spacing
- Primary CTA: dark filled pill button
- Secondary CTA: ghost pill with quiet border
- Hover: links shift toward Slate or gain subtle underline
- Mobile: clean off-canvas or full-screen light overlay
- Transition: background 300ms ease, border-color 300ms ease

### Image Treatment

- Product screenshots: placed in clean white or sage-tinted frames
- Container borders: subtle `#D9E5DD`, never heavy
- Aspect ratios: flexible, but hero imagery should still feel cinematic and intentional
- Avoid harsh drop-shadows or loud image framing
- Use soft backplates or faint gradients to integrate images into the page

### Trust Indicators

- Large numeric callouts remain prominent
- Display figures use NeueHaasGrotesk at large scale in Ink or Slate
- Labels and descriptions use Muted Text
- Sections may sit on Mist (`#F6FBF7`) or Paper (`#FFFFFF`) backgrounds for rhythm

## 5. Layout Principles

### Spacing System

Base unit: 8px

| Token | Value | Use |
|-------|-------|-----|
| space-1 | 4px | Tight inline gaps |
| space-2 | 8px | Base unit, icon gaps |
| space-3 | 12px | Card padding, tight margins |
| space-4 | 16px | Standard element padding |
| space-5 | 24px | Card gaps, section padding |
| space-6 | 28px | Medium section spacing |
| space-7 | 32px | Section breaks |
| space-8 | 36px | Large padding |
| space-9 | 40px | Major section padding |
| space-10 | 64px | Hero section padding, large gaps |

### Grid & Container

- Max container width: ~1280px centered
- Hero: full-width with a bright atmospheric wash and centered content
- Feature sections: 2-column layouts pairing text with clean product imagery
- Stats sections: horizontal layout with large numbers and ample separation
- Horizontal padding: 64px desktop, 32px tablet, 16px mobile
- Grid gap: 24-32px between major content blocks

### Whitespace Philosophy

The original theatrical pacing should remain intact. Light mode should not become cramped simply because the background is brighter. Sections still need generous breathing room — 80px to 120px between major content blocks — so the scroll retains its keynote-style cadence.

The contrast changes from darkness versus light to density versus openness. Large bright fields of whitespace create calm and authority; concentrated content blocks create the moments of focus.

### Border Radius Scale

| Value | Context |
|-------|---------|
| 4px | Tags, badges, micro-elements |
| 8px | Standard cards, inputs, media frames |
| 12px | Featured cards, image containers, non-pill buttons |
| 20px | Top-rounded cards, modal headers |
| 340px | Decorative large rounded shapes |
| 9999px | Pill buttons, pill badges, nav elements |

## 6. Depth & Elevation

| Level | Treatment | Use |
|-------|-----------|-----|
| Base | No shadow, light surface | Root page background |
| Subtle | 1px soft border + faint shadow | Resting cards |
| Medium | 1px border + 2px/8px/24px layered shadow | Elevated cards, feature panels |
| High | `rgba(17,17,17,0.12) 0px 20px 40px -12px` | Modals, dropdowns, overlays |
| Focus | `0px 0px 0px 2px #36F4A4` | Keyboard focus ring |

In light mode, shadows should feel like soft separation rather than dramatic float. Borders become more important than they were in the dark version, because they define edges without adding visual heaviness. The best effect is a combination of hairline borders and restrained, diffuse shadows.

### Decorative Depth

- **Atmospheric green washes** behind hero sections
- **Soft spotlight gradients** for keynote-like framing
- **Subtle edge highlights** via inset white sheen on elevated cards
- **Pale sage halos** behind featured content to echo the original green character

## 7. Do's and Don'ts

### Do

- Preserve the original typography system almost exactly
- Use warm whites and mint-tinted neutrals instead of stark blue-white backgrounds
- Keep Neon Green (`#36F4A4`) limited to focus, active, and highlight states
- Maintain full-pill CTAs as the primary interaction shape
- Use soft borders plus layered shadows for depth
- Preserve large section spacing and cinematic pacing
- Keep imagery framed cleanly and quietly
- Let the mood feel editorial and premium, not utilitarian

### Don't

- Don't turn the system into generic white SaaS UI
- Don't use pure white everywhere without tonal variation
- Don't fill large sections with Neon Green
- Don't make headings heavy; the light-weight display feel is essential
- Don't remove borders entirely; light mode needs edge definition
- Don't use harsh gray shadows or muddy midtone backgrounds
- Don't collapse spacing just because the theme is brighter
- Don't introduce warm accent colors that break the cool brand identity

## 8. Responsive Behavior

### Breakpoints

| Name | Width | Key Changes |
|------|-------|-------------|
| Mobile | <640px | Single column, compact nav, display text scales to 48px, 16px padding |
| Tablet | 640-1024px | 2-column layouts begin, display text at 70px, 32px padding |
| Desktop | 1024-1440px | Full layout, expanded nav, 96px display, 64px padding |
| Large Desktop | >1440px | Max-width container centered, increased section spacing |

### Touch Targets

- Minimum touch target: 44x44px
- Pill buttons: 48px height minimum
- Nav links: 44px touch area
- Clickable cards: full card tappable where appropriate

### Collapsing Strategy

- **Navigation**: horizontal links collapse to hamburger below 1024px
- **Hero section**: 96px display → 70px tablet → 48px mobile
- **Feature sections**: 2-column → single column below 768px
- **Stats**: horizontal row → stacked vertical on mobile
- **Section padding**: 64px → 40px → 24px → 16px as viewport narrows
- **Cards**: grid → stack while preserving generous internal spacing

### Image Behavior

- Screenshots remain responsive and lightly framed
- Hero imagery should scale proportionally and remain visually quiet
- Section media can sit on faint sage backplates to preserve system continuity
- Use responsive assets and careful cropping to avoid clutter on mobile

## 9. Agent Prompt Guide

### Quick Color Reference

- Primary CTA: Ink (`#111111`)
- CTA text: Studio White (`#FFFFFF`)
- Page background: Soft Ivory (`#FCFCF8`)
- Section background: Mist (`#F6FBF7`)
- Card surface: Paper (`#FFFFFF`)
- Elevated surface: Sage Wash (`#F1F7F3`)
- Accent: Neon Green (`#36F4A4`)
- Primary text: Ink (`#111111`)
- Muted text: Muted Text (`#4B5563`)
- Border: Card Border (`#D9E5DD`)

### Example Component Prompts

- "Create a hero section on Soft Ivory (`#FCFCF8`) with a 96px/330 NeueHaasGrotesk headline in Ink (`#111111`), a 20px/500 subtitle in `#4B5563`, and two pill buttons: dark filled and ghost with a `#D9E5DD` border. Add a subtle green atmospheric radial wash behind the content."
- "Design a feature card on white with a 1px `#D9E5DD` border, 12px radius, and soft layered shadow, containing a 32px/360 Ink heading and 18px/400 muted body text."
- "Build a stats section on Mist (`#F6FBF7`) with oversized NeueHaasGrotesk figures in Ink, compact muted labels, and generous 64px spacing between stat blocks."
- "Create a sticky nav with translucent light background, dark wordmark left, 18px/500 Ink nav links, and a dark pill CTA on the right."
- "Design a soft badge using Sage Wash (`#F1F7F3`), subtle border, pill radius, and Slate text for a quiet premium feel."

### Iteration Guide

When refining screens generated with this system:
1. Preserve typography, spacing, and shape language first
2. Translate dark surfaces into layered light neutrals rather than flat white
3. Use green as a restrained signal, not a dominant surface color
4. Keep the emotional tone premium and editorial
5. Favor soft borders and diffuse shadows over obvious card elevation
6. Use atmospheric gradients to retain a sense of presentation and stagecraft
7. Ensure display type remains feather-light; avoid making headings look heavy
8. Maintain a consistent cool palette across all surfaces and accents

---

## Summary Principle

This is the same system, not a new one.

Keep the typography, spacing, shape language, and accent restraint. Change the environment from dark and cinematic to bright and gallery-like. The result should feel like the original design walked from a keynote auditorium into a sunlit studio — still precise, still elevated, still unmistakably the same brand voice.
