---
issue: 35
title: "[Theme] Wishlist page — static HTML and CSS layout"
branch: feat/wishlist-static-layout-35
status: in-progress
last_updated: 04-02-2026
---

# Issue #35 — Wishlist Page — Static HTML and CSS Layout

**Branch:** `feat/wishlist-static-layout-35`
**Paper references:** `Waggy — Wishlist` (1440) · `Waggy — Wishlist Tablet` (768) · `Waggy — Wishlist Mobile` (390)

---

## Page structure (4 sections)

```
1. Wishlist Hero       — 2-col desktop, 1-col tablet/mobile
2. Wishlist Products   — section header + 4-col grid + filter bar
3. Wishlist Journal    — section header + 2-col article cards
4. Wishlist CTA        — 2 side-by-side cards (dark + light)
```

---

## Files to create

| File | Action |
|---|---|
| `templates/views-view--wishlist.html.twig` | New — full static page |
| `css/base/wishlist-styling.css` | New — complete CSS |
| `doljak_theme.libraries.yml` | Add `css/base/wishlist-styling.css: {}` under `css: base:` |

**Do NOT create** `views-view-unformatted` or `views-view-fields` templates — all content is static inside the main template.

---

## Design tokens (all defined in global.css)

```
--color-bg-base          #FAF7F2 — page background
--color-bg-hero          warm off-white — card/panel surfaces
--color-bg-card-warm     #F0E8DC — product card warm
--color-bg-card-green    #E2EDD8 — product card green
--color-bg-card-blue     #D8EAF0 — product card blue
--color-bg-card-pink     #F0D8E8 — product card pink
--color-bg-dark          #444241 — dark CTA card
--color-text-primary     #1A1714
--color-text-secondary   #5A575F
--color-text-light       #8A8480
--color-text-white       #ffffff
--color-accent           #C97B3F — orange
--color-accent-dark      darker orange (hover)
--color-border           #E5DDD3
--color-cat-cat          green badge color
--color-cat-bird         blue badge color
--font-display           'Syne', sans-serif
--font-body              'Montserrat', sans-serif
--font-regular / --font-medium / --font-semibold
--radius-xl / --radius-lg / --radius-pill / --radius-full
--shadow-md / --shadow-sm
--gutter                 80px
--container-inner        1280px
--space-* / --text-* / --transition-fast
```

---

## Task 1 — `doljak_theme.libraries.yml`

Add after `auth-styling.css`:

```yaml
      css/base/wishlist-styling.css: {}
```

---

## Task 2 — `templates/views-view--wishlist.html.twig`

```twig
{#
  views-view--wishlist.html.twig
  Static layout — Waggy Wishlist page.
  Paper: Waggy — Wishlist (desktop / tablet / mobile)

  Sections:
    1. .wishlist-hero      — 2-col header with Collection Pulse panel
    2. .wishlist-products  — section header + 4-col product grid + filter bar
    3. .wishlist-journal   — section header + 2-col article cards
    4. .wishlist-cta       — 2 side-by-side cards (dark + light)
#}

{# ------------------------------------------------------------------ #}
{# DATA                                                                #}
{# ------------------------------------------------------------------ #}
{% set products = [
  { color: 'warm', badge: 'NEW',  badge_mod: 'new',   category: 'Dog food',     title: 'Premium Dry Food Mix',    price: '24.99', compare: '',      usage: 'Daily nutrition' },
  { color: 'green',badge: 'BEST', badge_mod: 'best',  category: 'Accessories',  title: 'Comfort Pet Harness',     price: '34.99', compare: '',      usage: 'Comfort first'   },
  { color: 'blue', badge: '-15%', badge_mod: 'sale',  category: 'Cat toys',     title: 'Interactive Play Set',    price: '18.99', compare: '22.99', usage: 'Indoor energy'   },
  { color: 'pink', badge: 'HOT',  badge_mod: 'hot',   category: 'Grooming',     title: 'Soft Grooming Brush',     price: '14.99', compare: '',      usage: 'Bath time'       }
] %}

{% set articles = [
  {
    category: 'ROUTINE', date: 'Apr 02, 2026',
    title: 'How to build a calmer daily routine for your dog',
    excerpt: 'Meal timing, play windows and gentle rest cues can change the mood of the whole house. This piece turns routine into something realistic and repeatable.',
    tags: ['Behavior', 'Home rhythm']
  },
  {
    category: 'NUTRITION', date: 'Apr 05, 2026',
    title: "What to watch before changing your pet's food",
    excerpt: 'A simple checklist for transitions that feel gentler on digestion and still keep the feeding routine premium and well organized.',
    tags: ['Food change', 'Digestive care']
  }
] %}

{# ------------------------------------------------------------------ #}
{# SECTION 1 — HERO                                                    #}
{# ------------------------------------------------------------------ #}
<section class="wishlist-hero">
  <div class="wishlist-hero__inner">

    <div class="wishlist-hero__copy">
      <span class="wishlist-hero__eyebrow">Saved for later</span>
      <h1 class="wishlist-hero__headline">Wishlist that keeps the shop and the journal in sync.</h1>
      <p class="wishlist-hero__description">A single place to hold favorite products, compare routines, and keep the most useful reads close before the next checkout decision.</p>

      <ul class="wishlist-hero__chips" aria-label="Wishlist summary">
        <li class="wishlist-hero__chip">06 products</li>
        <li class="wishlist-hero__chip">03 articles</li>
        <li class="wishlist-hero__chip">02 routines</li>
      </ul>

      <div class="wishlist-hero__actions">
        <a href="#" class="wishlist-hero__action wishlist-hero__action--primary">Move all to cart</a>
        <a href="#" class="wishlist-hero__action wishlist-hero__action--outline">Open journal picks</a>
      </div>
    </div>

    <aside class="wishlist-hero__panel" aria-label="Collection pulse">
      <div class="wishlist-hero__pulse-card">
        <div class="wishlist-hero__pulse-header">
          <div class="wishlist-hero__pulse-copy">
            <span class="wishlist-hero__pulse-eyebrow">Collection Pulse</span>
            <h2 class="wishlist-hero__pulse-title">Everything worth revisiting this week.</h2>
          </div>
          <div class="wishlist-hero__pulse-heart" aria-hidden="true">♥</div>
        </div>
        <div class="wishlist-hero__counters">
          <div class="wishlist-hero__counter">
            <span class="wishlist-hero__counter-label">Ready next</span>
            <span class="wishlist-hero__counter-value">2</span>
            <span class="wishlist-hero__counter-note">Closest to checkout</span>
          </div>
          <div class="wishlist-hero__counter">
            <span class="wishlist-hero__counter-label">Need reading</span>
            <span class="wishlist-hero__counter-value">3</span>
            <span class="wishlist-hero__counter-note">Have matching journal notes</span>
          </div>
        </div>
      </div>

      <div class="wishlist-hero__journal-card">
        <div class="wishlist-hero__journal-image"></div>
        <div class="wishlist-hero__journal-body">
          <span class="wishlist-hero__journal-eyebrow">From the Journal</span>
          <p class="wishlist-hero__journal-text">Two saved products already have calm care guidance.</p>
          <p class="wishlist-hero__journal-sub">Use the reading stack below to compare routines before buying.</p>
        </div>
      </div>
    </aside>

  </div>
</section>

{# ------------------------------------------------------------------ #}
{# SECTION 2 — PRODUCTS                                               #}
{# ------------------------------------------------------------------ #}
<section class="wishlist-products">
  <div class="wishlist-products__inner">

    <div class="wishlist-products__header">
      <div class="wishlist-products__header-copy">
        <span class="wishlist-section-eyebrow">Your products</span>
        <h2 class="wishlist-section-title">Items you want to come back to.</h2>
      </div>
      <p class="wishlist-products__description">The list keeps the same visual rhythm as the shop grid, but pairs each save with the reading layer that supports the decision.</p>
    </div>

    <div class="wishlist-products__grid">
      {% for product in products %}
        <article class="wishlist-card wishlist-card--{{ product.color }}">
          <div class="wishlist-card__image-wrap">
            {% if product.badge %}
              <span class="wishlist-card__badge wishlist-card__badge--{{ product.badge_mod }}">{{ product.badge }}</span>
            {% endif %}
          </div>
          <div class="wishlist-card__content">
            <span class="wishlist-card__category">{{ product.category }}</span>
            <h3 class="wishlist-card__title">{{ product.title }}</h3>
            <div class="wishlist-card__footer">
              <div class="wishlist-card__price-block">
                <div class="wishlist-card__price-row">
                  <span class="wishlist-card__price">${{ product.price }}</span>
                  {% if product.compare %}
                    <span class="wishlist-card__compare-price">${{ product.compare }}</span>
                  {% endif %}
                </div>
                {% if product.usage %}
                  <span class="wishlist-card__usage">{{ product.usage }}</span>
                {% endif %}
              </div>
              <a href="#" class="wishlist-card__add" aria-label="Add to cart">+</a>
            </div>
          </div>
        </article>
      {% endfor %}
    </div>

    <div class="wishlist-products__filter-bar">
      <div class="wishlist-products__filter-chips">
        <span class="wishlist-products__filter-chip">Shared with cart</span>
        <span class="wishlist-products__filter-chip wishlist-products__filter-chip--active">Linked to Journal</span>
        <span class="wishlist-products__filter-chip">Sorted by most recent save</span>
      </div>
      <a href="#" class="wishlist-products__share">Share list →</a>
    </div>

  </div>
</section>

{# ------------------------------------------------------------------ #}
{# SECTION 3 — JOURNAL LINK                                           #}
{# ------------------------------------------------------------------ #}
<section class="wishlist-journal">
  <div class="wishlist-journal__inner">

    <div class="wishlist-journal__header">
      <div class="wishlist-journal__header-copy">
        <span class="wishlist-section-eyebrow">Read before you buy</span>
        <h2 class="wishlist-section-title">Journal stories connected to what you saved.</h2>
      </div>
      <p class="wishlist-journal__description">These reads answer the exact categories already sitting in the wishlist, so the page moves naturally between product intent and practical care guidance.</p>
    </div>

    <div class="wishlist-journal__grid">
      {% for article in articles %}
        <article class="wishlist-article-card">
          <div class="wishlist-article-card__image-wrap"></div>
          <div class="wishlist-article-card__content">
            <div class="wishlist-article-card__meta">
              <span class="wishlist-article-card__category">{{ article.category }}</span>
              <span class="wishlist-article-card__date">{{ article.date }}</span>
            </div>
            <h3 class="wishlist-article-card__title">{{ article.title }}</h3>
            <p class="wishlist-article-card__excerpt">{{ article.excerpt }}</p>
            <div class="wishlist-article-card__footer">
              <div class="wishlist-article-card__tags">
                {% for tag in article.tags %}
                  <span class="wishlist-article-card__tag">{{ tag }}</span>
                {% endfor %}
              </div>
              <a href="#" class="wishlist-article-card__cta">Read article</a>
            </div>
          </div>
        </article>
      {% endfor %}
    </div>

  </div>
</section>

{# ------------------------------------------------------------------ #}
{# SECTION 4 — CTA                                                    #}
{# ------------------------------------------------------------------ #}
<section class="wishlist-cta">
  <div class="wishlist-cta__inner">

    <div class="wishlist-cta__dark-card">
      <span class="wishlist-cta__card-eyebrow">Wishlist flow</span>
      <h2 class="wishlist-cta__dark-title">Save, read, then decide with more clarity.</h2>
      <p class="wishlist-cta__dark-copy">The page is designed to feel useful before it feels urgent, so shoppers can move from inspiration to purchase with less friction.</p>
    </div>

    <div class="wishlist-cta__light-card">
      <div class="wishlist-cta__light-top">
        <span class="wishlist-cta__card-eyebrow">Next moves</span>
        <a href="#" class="wishlist-cta__arrow" aria-label="Take action">→</a>
      </div>
      <h2 class="wishlist-cta__light-title">Turn the saved list into action whenever the timing is right.</h2>
      <div class="wishlist-cta__action-chips">
        <a href="#" class="wishlist-cta__action-chip">Move favorites to cart</a>
        <a href="#" class="wishlist-cta__action-chip">Share list with someone</a>
        <a href="#" class="wishlist-cta__action-chip">Keep reading related care tips</a>
      </div>
    </div>

  </div>
</section>
```

---

## Task 3 — `css/base/wishlist-styling.css`

```css
/* ==========================================================================
   WISHLIST PAGE
   ========================================================================== */

/* Shared section eyebrow and title */
.wishlist-section-eyebrow {
  color: var(--color-text-light);
  font-family: var(--font-body);
  font-size: var(--text-xs);
  font-weight: var(--font-medium);
  letter-spacing: 0.2em;
  text-transform: uppercase;
}

.wishlist-section-title {
  color: var(--color-text-primary);
  font-family: var(--font-display);
  font-size: var(--text-3xl);
  font-weight: var(--font-regular);
  line-height: 1.05;
  margin: 0;
}

/* --------------------------------------------------------------------------
   SECTION 1 — HERO
   -------------------------------------------------------------------------- */

.wishlist-hero {
  padding: 56px var(--gutter) 64px;
}

.wishlist-hero__inner {
  display: grid;
  gap: 48px;
  grid-template-columns: minmax(0, 1.1fr) minmax(0, 0.9fr);
  margin: 0 auto;
  max-width: var(--container-inner);
}

/* Left — copy */

.wishlist-hero__copy {
  display: flex;
  flex-direction: column;
  gap: var(--space-5);
  justify-content: center;
}

.wishlist-hero__eyebrow {
  color: var(--color-text-light);
  font-family: var(--font-body);
  font-size: var(--text-xs);
  font-weight: var(--font-medium);
  letter-spacing: 0.2em;
  text-transform: uppercase;
}

.wishlist-hero__headline {
  color: var(--color-text-primary);
  font-family: var(--font-display);
  font-size: clamp(40px, 5vw, 68px);
  font-weight: var(--font-regular);
  line-height: 1;
  margin: 0;
}

.wishlist-hero__description {
  color: var(--color-text-secondary);
  font-family: var(--font-body);
  font-size: var(--text-base);
  line-height: 1.75;
  margin: 0;
  max-width: 580px;
}

.wishlist-hero__chips {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3);
  list-style: none;
  margin: 0;
  padding: 0;
}

.wishlist-hero__chip {
  border: 1px solid var(--color-border);
  border-radius: var(--radius-pill);
  color: var(--color-text-secondary);
  font-family: var(--font-body);
  font-size: var(--text-sm);
  padding: 6px 16px;
}

.wishlist-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3);
}

.wishlist-hero__action {
  align-items: center;
  border-radius: var(--radius-pill);
  display: inline-flex;
  font-family: var(--font-body);
  font-size: var(--text-sm);
  font-weight: var(--font-semibold);
  min-height: 50px;
  padding: 0 var(--space-8);
  transition: background-color var(--transition-fast), color var(--transition-fast);
}

.wishlist-hero__action--primary {
  background-color: var(--color-accent);
  color: var(--color-text-white);
}

.wishlist-hero__action--primary:hover {
  background-color: var(--color-accent-dark);
}

.wishlist-hero__action--outline {
  background-color: transparent;
  border: 1px solid var(--color-border);
  color: var(--color-text-primary);
}

.wishlist-hero__action--outline:hover {
  border-color: var(--color-text-primary);
}

/* Right — Collection Pulse panel */

.wishlist-hero__panel {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.wishlist-hero__pulse-card {
  background-color: var(--color-text-white);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-xl);
  box-shadow: var(--shadow-sm);
  display: flex;
  flex-direction: column;
  gap: 20px;
  padding: 28px;
}

.wishlist-hero__pulse-header {
  align-items: flex-start;
  display: flex;
  gap: var(--space-4);
  justify-content: space-between;
}

.wishlist-hero__pulse-copy {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.wishlist-hero__pulse-eyebrow {
  color: var(--color-text-light);
  font-family: var(--font-body);
  font-size: var(--text-xs);
  letter-spacing: 0.16em;
  text-transform: uppercase;
}

.wishlist-hero__pulse-title {
  color: var(--color-text-primary);
  font-family: var(--font-display);
  font-size: var(--text-xl);
  font-weight: var(--font-regular);
  line-height: 1.15;
  margin: 0;
}

.wishlist-hero__pulse-heart {
  align-items: center;
  background-color: #F5E6D8;
  border-radius: var(--radius-full);
  color: var(--color-accent);
  display: flex;
  flex-shrink: 0;
  font-size: 18px;
  height: 44px;
  justify-content: center;
  width: 44px;
}

.wishlist-hero__counters {
  display: grid;
  gap: 12px;
  grid-template-columns: 1fr 1fr;
}

.wishlist-hero__counter {
  background-color: var(--color-bg-base);
  border-radius: var(--radius-lg);
  display: flex;
  flex-direction: column;
  gap: 4px;
  padding: 16px 18px;
}

.wishlist-hero__counter-label {
  color: var(--color-text-light);
  font-family: var(--font-body);
  font-size: var(--text-xs);
  letter-spacing: 0.12em;
  text-transform: uppercase;
}

.wishlist-hero__counter-value {
  color: var(--color-text-primary);
  font-family: var(--font-display);
  font-size: 40px;
  font-weight: var(--font-regular);
  line-height: 1;
}

.wishlist-hero__counter-note {
  color: var(--color-text-secondary);
  font-family: var(--font-body);
  font-size: var(--text-xs);
  line-height: 1.4;
}

/* Journal teaser card (dark) */

.wishlist-hero__journal-card {
  background-color: #3E3D3B;
  border-radius: var(--radius-xl);
  display: flex;
  gap: 20px;
  overflow: hidden;
  padding: 24px;
}

.wishlist-hero__journal-image {
  background-color: #5A5652;
  border-radius: var(--radius-lg);
  flex-shrink: 0;
  height: 100px;
  width: 130px;
}

.wishlist-hero__journal-body {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.wishlist-hero__journal-eyebrow {
  color: rgba(255, 244, 235, 0.6);
  font-family: var(--font-body);
  font-size: var(--text-xs);
  letter-spacing: 0.14em;
  text-transform: uppercase;
}

.wishlist-hero__journal-text {
  color: var(--color-text-white);
  font-family: var(--font-display);
  font-size: var(--text-lg);
  font-weight: var(--font-regular);
  line-height: 1.2;
  margin: 0;
}

.wishlist-hero__journal-sub {
  color: rgba(255, 244, 235, 0.7);
  font-family: var(--font-body);
  font-size: var(--text-xs);
  line-height: 1.6;
  margin: 0;
}

/* --------------------------------------------------------------------------
   SECTION 2 — PRODUCTS
   -------------------------------------------------------------------------- */

.wishlist-products {
  padding: 64px var(--gutter);
}

.wishlist-products__inner {
  display: flex;
  flex-direction: column;
  gap: var(--space-8);
  margin: 0 auto;
  max-width: var(--container-inner);
}

.wishlist-products__header {
  align-items: flex-end;
  display: flex;
  gap: 48px;
  justify-content: space-between;
}

.wishlist-products__header-copy {
  display: flex;
  flex-direction: column;
  gap: var(--space-3);
}

.wishlist-products__description {
  color: var(--color-text-secondary);
  font-family: var(--font-body);
  font-size: var(--text-sm);
  line-height: 1.75;
  margin: 0;
  max-width: 380px;
}

/* Product grid — 4 columns */

.wishlist-products__grid {
  display: grid;
  gap: var(--space-5);
  grid-template-columns: repeat(4, minmax(0, 1fr));
}

/* Product cards */

.wishlist-card {
  background-color: var(--color-text-white);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-xl);
  box-shadow: var(--shadow-md);
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.wishlist-card__image-wrap {
  min-height: 220px;
  padding: var(--space-4);
  position: relative;
}

.wishlist-card--warm .wishlist-card__image-wrap  { background-color: var(--color-bg-card-warm); }
.wishlist-card--green .wishlist-card__image-wrap { background-color: var(--color-bg-card-green); }
.wishlist-card--blue .wishlist-card__image-wrap  { background-color: var(--color-bg-card-blue); }
.wishlist-card--pink .wishlist-card__image-wrap  { background-color: var(--color-bg-card-pink); }

.wishlist-card__badge {
  align-items: center;
  background-color: var(--color-accent);
  border-radius: var(--radius-pill);
  bottom: var(--space-4);
  color: var(--color-text-white);
  display: inline-flex;
  font-family: var(--font-body);
  font-size: var(--text-xs);
  font-weight: var(--font-semibold);
  left: var(--space-4);
  letter-spacing: 0.08em;
  min-height: 28px;
  padding: 0 var(--space-3);
  position: absolute;
  text-transform: uppercase;
}

.wishlist-card__badge--best { background-color: var(--color-cat-cat); }
.wishlist-card__badge--sale { background-color: var(--color-cat-bird); }
.wishlist-card__badge--hot  { background-color: #9B6B9B; }

.wishlist-card__content {
  display: flex;
  flex: 1;
  flex-direction: column;
  gap: var(--space-2);
  padding: var(--space-4);
}

.wishlist-card__category {
  color: var(--color-text-light);
  font-family: var(--font-body);
  font-size: var(--text-xs);
  letter-spacing: 0.1em;
  text-transform: uppercase;
}

.wishlist-card__title {
  color: var(--color-text-primary);
  font-family: var(--font-display);
  font-size: var(--text-xl);
  font-weight: var(--font-regular);
  line-height: 1.15;
  margin: 0;
}

.wishlist-card__footer {
  align-items: flex-end;
  display: flex;
  gap: var(--space-3);
  justify-content: space-between;
  margin-top: auto;
  padding-top: var(--space-3);
}

.wishlist-card__price-block {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.wishlist-card__price-row {
  align-items: baseline;
  display: flex;
  gap: var(--space-2);
}

.wishlist-card__price {
  color: var(--color-text-primary);
  font-family: var(--font-display);
  font-size: var(--text-xl);
  line-height: 1.1;
}

.wishlist-card__compare-price {
  color: var(--color-text-light);
  font-family: var(--font-body);
  font-size: var(--text-xs);
  text-decoration: line-through;
}

.wishlist-card__usage {
  color: var(--color-text-light);
  font-family: var(--font-body);
  font-size: var(--text-xs);
  line-height: 1.4;
}

.wishlist-card__add {
  align-items: center;
  background-color: var(--color-accent);
  border-radius: var(--radius-full);
  color: var(--color-text-white);
  display: inline-flex;
  flex-shrink: 0;
  font-family: var(--font-display);
  font-size: var(--text-xl);
  height: 44px;
  justify-content: center;
  line-height: 1;
  transition: background-color var(--transition-fast), transform var(--transition-fast);
  width: 44px;
}

.wishlist-card__add:hover {
  background-color: var(--color-accent-dark);
  transform: translateY(-1px);
}

/* Filter bar */

.wishlist-products__filter-bar {
  align-items: center;
  background-color: var(--color-text-white);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-pill);
  display: flex;
  gap: var(--space-4);
  justify-content: space-between;
  padding: 14px 24px;
}

.wishlist-products__filter-chips {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3);
}

.wishlist-products__filter-chip {
  color: var(--color-text-secondary);
  font-family: var(--font-body);
  font-size: var(--text-sm);
}

.wishlist-products__filter-chip--active {
  color: var(--color-text-primary);
  font-weight: var(--font-semibold);
}

.wishlist-products__share {
  color: var(--color-accent-dark);
  flex-shrink: 0;
  font-family: var(--font-body);
  font-size: var(--text-sm);
  font-weight: var(--font-medium);
  transition: color var(--transition-fast);
  white-space: nowrap;
}

.wishlist-products__share:hover {
  color: var(--color-accent);
}

/* --------------------------------------------------------------------------
   SECTION 3 — JOURNAL LINK
   -------------------------------------------------------------------------- */

.wishlist-journal {
  padding: 64px var(--gutter) 80px;
}

.wishlist-journal__inner {
  display: flex;
  flex-direction: column;
  gap: var(--space-8);
  margin: 0 auto;
  max-width: var(--container-inner);
}

.wishlist-journal__header {
  align-items: flex-end;
  display: flex;
  gap: 48px;
  justify-content: space-between;
}

.wishlist-journal__header-copy {
  display: flex;
  flex-direction: column;
  gap: var(--space-3);
}

.wishlist-journal__description {
  color: var(--color-text-secondary);
  font-family: var(--font-body);
  font-size: var(--text-sm);
  line-height: 1.75;
  margin: 0;
  max-width: 380px;
}

/* 2-column article card grid */

.wishlist-journal__grid {
  display: grid;
  gap: var(--space-6);
  grid-template-columns: repeat(2, minmax(0, 1fr));
}

.wishlist-article-card {
  background-color: var(--color-text-white);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-xl);
  box-shadow: var(--shadow-md);
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.wishlist-article-card__image-wrap {
  aspect-ratio: 16 / 7;
  background-color: var(--color-bg-hero);
}

.wishlist-article-card__content {
  display: flex;
  flex: 1;
  flex-direction: column;
  gap: var(--space-4);
  padding: var(--space-5);
}

.wishlist-article-card__meta {
  align-items: center;
  display: flex;
  gap: var(--space-4);
  justify-content: space-between;
}

.wishlist-article-card__category {
  color: var(--color-text-light);
  font-family: var(--font-body);
  font-size: var(--text-xs);
  letter-spacing: 0.12em;
  text-transform: uppercase;
}

.wishlist-article-card__date {
  color: var(--color-text-light);
  font-family: var(--font-body);
  font-size: var(--text-xs);
}

.wishlist-article-card__title {
  color: var(--color-text-primary);
  font-family: var(--font-display);
  font-size: var(--text-2xl);
  font-weight: var(--font-regular);
  line-height: 1.1;
  margin: 0;
}

.wishlist-article-card__excerpt {
  color: var(--color-text-secondary);
  font-family: var(--font-body);
  font-size: var(--text-sm);
  line-height: 1.75;
  margin: 0;
}

.wishlist-article-card__footer {
  align-items: flex-end;
  display: flex;
  gap: var(--space-4);
  justify-content: space-between;
  margin-top: auto;
}

.wishlist-article-card__tags {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-2);
}

.wishlist-article-card__tag {
  background-color: var(--color-bg-base);
  border-radius: var(--radius-pill);
  color: var(--color-text-secondary);
  font-family: var(--font-body);
  font-size: var(--text-xs);
  padding: 4px 12px;
}

.wishlist-article-card__cta {
  color: var(--color-accent-dark);
  flex-shrink: 0;
  font-family: var(--font-body);
  font-size: var(--text-sm);
  font-weight: var(--font-medium);
  transition: color var(--transition-fast);
  white-space: nowrap;
}

.wishlist-article-card__cta:hover {
  color: var(--color-accent);
}

/* --------------------------------------------------------------------------
   SECTION 4 — CTA
   -------------------------------------------------------------------------- */

.wishlist-cta {
  padding: 0 var(--gutter) 96px;
}

.wishlist-cta__inner {
  display: grid;
  gap: var(--space-5);
  grid-template-columns: minmax(0, 0.55fr) minmax(0, 1fr);
  margin: 0 auto;
  max-width: var(--container-inner);
}

/* Dark card */

.wishlist-cta__dark-card {
  background-color: var(--color-bg-dark);
  border-radius: var(--radius-xl);
  display: flex;
  flex-direction: column;
  gap: var(--space-4);
  padding: var(--space-8) var(--space-8) var(--space-10);
}

.wishlist-cta__card-eyebrow {
  color: rgba(255, 244, 235, 0.55);
  font-family: var(--font-body);
  font-size: var(--text-xs);
  letter-spacing: 0.16em;
  text-transform: uppercase;
}

.wishlist-cta__dark-title {
  color: var(--color-text-white);
  font-family: var(--font-display);
  font-size: var(--text-2xl);
  font-weight: var(--font-regular);
  line-height: 1.1;
  margin: 0;
}

.wishlist-cta__dark-copy {
  color: rgba(255, 244, 235, 0.65);
  font-family: var(--font-body);
  font-size: var(--text-sm);
  line-height: 1.75;
  margin: 0;
  margin-top: auto;
}

/* Light card */

.wishlist-cta__light-card {
  background-color: var(--color-text-white);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-xl);
  box-shadow: var(--shadow-md);
  display: flex;
  flex-direction: column;
  gap: var(--space-5);
  padding: var(--space-8);
}

.wishlist-cta__light-top {
  align-items: flex-start;
  display: flex;
  justify-content: space-between;
}

.wishlist-cta__light-card .wishlist-cta__card-eyebrow {
  color: var(--color-text-light);
}

.wishlist-cta__arrow {
  align-items: center;
  background-color: var(--color-accent);
  border-radius: var(--radius-full);
  color: var(--color-text-white);
  display: inline-flex;
  flex-shrink: 0;
  font-size: 20px;
  height: 44px;
  justify-content: center;
  transition: background-color var(--transition-fast);
  width: 44px;
}

.wishlist-cta__arrow:hover {
  background-color: var(--color-accent-dark);
}

.wishlist-cta__light-title {
  color: var(--color-text-primary);
  font-family: var(--font-display);
  font-size: var(--text-2xl);
  font-weight: var(--font-regular);
  line-height: 1.1;
  margin: 0;
}

.wishlist-cta__action-chips {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3);
  margin-top: auto;
}

.wishlist-cta__action-chip {
  border: 1px solid var(--color-border);
  border-radius: var(--radius-pill);
  color: var(--color-text-primary);
  font-family: var(--font-body);
  font-size: var(--text-sm);
  padding: 8px 18px;
  transition: border-color var(--transition-fast), color var(--transition-fast);
}

.wishlist-cta__action-chip:hover {
  border-color: var(--color-accent);
  color: var(--color-accent-dark);
}

/* --------------------------------------------------------------------------
   RESPONSIVE — ≤ 1100px (tablet large)
   -------------------------------------------------------------------------- */

@media (max-width: 1100px) {
  .wishlist-hero,
  .wishlist-products,
  .wishlist-journal,
  .wishlist-cta {
    padding-left: 40px;
    padding-right: 40px;
  }

  .wishlist-products__header,
  .wishlist-journal__header {
    align-items: flex-start;
    flex-direction: column;
    gap: var(--space-4);
  }

  .wishlist-products__description,
  .wishlist-journal__description {
    max-width: 100%;
  }

  .wishlist-cta__inner {
    grid-template-columns: 1fr;
  }
}

/* --------------------------------------------------------------------------
   RESPONSIVE — ≤ 820px (tablet)
   -------------------------------------------------------------------------- */

@media (max-width: 820px) {
  .wishlist-hero__inner {
    grid-template-columns: 1fr;
  }

  .wishlist-hero__headline {
    font-size: var(--text-3xl);
  }

  .wishlist-section-title {
    font-size: var(--text-2xl);
  }

  .wishlist-products__grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .wishlist-journal__grid {
    grid-template-columns: 1fr;
  }

  .wishlist-products__filter-bar {
    align-items: flex-start;
    border-radius: var(--radius-xl);
    flex-direction: column;
    gap: var(--space-3);
    padding: 18px 20px;
  }
}

/* --------------------------------------------------------------------------
   RESPONSIVE — ≤ 600px (mobile)
   -------------------------------------------------------------------------- */

@media (max-width: 600px) {
  .wishlist-hero,
  .wishlist-products,
  .wishlist-journal,
  .wishlist-cta {
    padding-left: 20px;
    padding-right: 20px;
  }

  .wishlist-hero__headline {
    font-size: var(--text-2xl);
  }

  .wishlist-hero__journal-card {
    flex-direction: column;
  }

  .wishlist-hero__journal-image {
    height: 140px;
    width: 100%;
  }

  .wishlist-hero__counters {
    grid-template-columns: 1fr 1fr;
  }

  .wishlist-products__grid {
    gap: var(--space-4);
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }

  .wishlist-card__image-wrap {
    min-height: 160px;
  }

  .wishlist-card__title {
    font-size: var(--text-base);
  }

  .wishlist-card__price {
    font-size: var(--text-lg);
  }

  .wishlist-article-card__footer {
    align-items: flex-start;
    flex-direction: column;
  }

  .wishlist-cta__dark-card,
  .wishlist-cta__light-card {
    padding: var(--space-6) var(--space-5);
  }
}
```

---

## After implementation

1. Run `ddev drush cr`
2. Verify at `/wishlist` (needs a route — create a basic page node or temporary Views page if needed)
3. Resize to 768px: hero stacks to 1 column, product grid 2 cols, journal grid 1 col
4. Resize to 390px: hero compact, product grid stays 2 cols, journal 1 col
5. Check badge colors: NEW=orange, BEST=green, -15%=blue, HOT=mauve/purple

---

## Design notes (from Paper)

- **Hero:** 2-col desktop — left: copy + chips + CTAs; right: white pulse card (counters) + dark journal teaser card
- **Hero chips:** outline pill chips (no fill), border only
- **Collection Pulse panel:** white card with inner counter cards on cream bg; dark card (charcoal #3E3D3B) with dog image + journal note
- **Product badges:** bottom-left of image area (not top-left as in shop) — warm/green/blue/pink bg per card variant
- **HOT badge color:** mauve/purple tone, not orange
- **Usage tag:** small muted text below price (e.g. "Daily nutrition")
- **Filter bar:** full-width below grid, pill shape, 3 status chips left + "Share list →" right
- **Journal articles:** image fills full width at top (aspect 16:7), cards identical to journal listing
- **CTA dark card:** charcoal (#444241), smaller width than light card (~40% / 60% split)
- **CTA light card:** white, border, "→" orange circle top-right, 3 outline action chips at bottom
- **Mobile product grid stays 2 columns** (does NOT collapse to 1)
