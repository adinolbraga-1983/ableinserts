# Motion: GSAP + React Bits + Framer-grade Feel

Three different sources describe the same underlying problem — good motion — from three
angles. Untangling which one to reach for avoids ending up with three animation libraries
doing overlapping jobs.

## GSAP is the engine

Use GSAP directly for anything beyond a simple CSS transition: sequenced timelines,
scroll-linked reveals (`ScrollTrigger`), staggered lists, text splitting (`SplitText`).
Since the Webflow acquisition, the full plugin set is free — there's no reason to reach for
a lighter/weaker alternative or to hand-roll `requestAnimationFrame` loops for things GSAP
already solves.

Baseline patterns worth defaulting to:
- `gsap.timeline()` for anything with more than one sequenced step, instead of chaining
  separate tweens with manual delays.
- `ScrollTrigger` with `scrub` for scroll-linked motion instead of listening to `scroll`
  events and computing offsets by hand.
- `ease: "power2.out"` (or similar) as a default over linear easing — linear motion reads
  as robotic and is one of the fastest tells of an under-designed interface.
- Always `gsap.matchMedia()` or an explicit `prefers-reduced-motion` check to disable or
  simplify motion for users who've asked for it.

## React Bits shows what GSAP-powered components can look like

Treat React Bits less as a component library to `npm install` wholesale and more as a
gallery of composed GSAP/canvas techniques: animated text reveal patterns, cursor-follow
effects, interactive dot/grid backgrounds. When a design brief calls for one of these
effects, look at how the category is typically built (text splitting + stagger, canvas
particle field bound to pointer position, etc.) and implement a version tuned to the
project instead of importing the component with its own opinions about font, color, and
timing baked in.

## Framer supplies the *feel*, even without the tool

Framer's contribution here isn't a tool integration — it's a vocabulary for how
professional motion design actually feels: spring physics (`type: "spring"`, tuned
`stiffness`/`damping`) rather than fixed-duration eases for anything that should feel
physical or draggable; layout animations that smoothly interpolate position/size changes
instead of snapping; micro-interaction timing in the 100-250ms range for hover/press states
so feedback reads as instant but not abrupt. When implementing these ideas in GSAP, mirror
the spring feel with `ease: "elastic.out(1, 0.5)"` or similar rather than only ever using
eased-duration curves — variety in easing across a page is often what separates "animated"
from "alive."

## Composing them

A typical build order:
1. Structure and static layout first, fully usable with motion off.
2. Entrance/scroll reveals via GSAP + ScrollTrigger.
3. Micro-interactions (hover, press, focus) tuned to Framer-grade spring timing.
4. One signature moment (a React-Bits-style text effect, a cursor interaction, a
   generative background) reserved for the highest-attention area of the page — not spread
   thin across every element, which reads as noisy rather than confident.
