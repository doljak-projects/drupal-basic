# Issue #32 — Blog Journey CSS Completion

**Branch:** `feat/blog-css-32-blog-journey-completion-css-responsiveness`
**Worktree:** `worktree-blog-css-32`
**Paper references:** `Waggy — Article` (desktop 1440 / tablet 768 / mobile 390)

---

## Situation audit (do not redo what is already done)

### Already complete — do NOT touch

| File | Status |
|---|---|
| `css/base/article-styling.css` | Hero, body, aside, tips, editor note, steps — fully styled with tablet + mobile responsive |
| `templates/node--article.html.twig` | Hero, body/aside, tip cards, editor note, steps list |
| `css/base/journal-styling.css` | 647 lines, 3 breakpoints (1100px / 820px / 560px) |
| `templates/views-view--journal.html.twig` | Dynamic — uses `{{ rows }}` + `{{ pager }}` |
| `templates/views-view-unformatted--journal.html.twig` | Dynamic grid |
| `templates/views-view-fields--journal.html.twig` | Dynamic article card |

### What is missing

1. **Comments section** — HTML block + CSS in `article-styling.css`
2. **Comment form** — HTML block + CSS in `article-styling.css`
3. Both are missing from `node--article.html.twig`

---

## Task 1 — Add comments section to `node--article.html.twig`

Add this block **after** the closing `</main>` tag and **before** `</div>` (the `.article-layout` wrapper), so it sits below body/aside at full width outside the two-column grid.

```twig
{# ------------------------------------------------------------------ #}
{# COMMENTS                                                            #}
{# ------------------------------------------------------------------ #}
<section class="article-comments">
  <div class="article-comments__inner">

    <div class="article-comments__heading">
      <span class="article-label">Comments</span>
      <h2 class="article-comments__title">What readers are adding to the conversation</h2>
    </div>

    <div class="article-comments__grid">

      <article class="article-comment-card">
        <h3 class="article-comment-card__author">Mia T.</h3>
        <p class="article-comment-card__text">The evening cue made the biggest difference for us. Once we dimmed the room before offering the chew, our dog stopped pacing through the hallway.</p>
      </article>

      <article class="article-comment-card">
        <h3 class="article-comment-card__author">Carlos P.</h3>
        <p class="article-comment-card__text">The midday reset tip is practical. We replaced random toy bursts with one sniffing game after lunch and the whole afternoon feels calmer now.</p>
      </article>

      <article class="article-comment-card">
        <h3 class="article-comment-card__author">Nadia R.</h3>
        <p class="article-comment-card__text">I liked that the routine feels realistic for weekdays. It is not about perfection, just giving the dog a clearer rhythm to trust.</p>
      </article>

    </div>

  </div>
</section>
```

---

## Task 2 — Add comment form to `node--article.html.twig`

Add this block **immediately after** the `.article-comments` section, still inside `<article{{ attributes... }}>`.

```twig
{# ------------------------------------------------------------------ #}
{# COMMENT FORM                                                        #}
{# ------------------------------------------------------------------ #}
<section class="article-comment-form">
  <div class="article-comment-form__inner">

    <h2 class="article-comment-form__title">Leave a comment</h2>

    <form class="article-comment-form__form" action="#" method="post" novalidate>

      <div class="article-comment-form__row">
        <div class="article-comment-form__field">
          <input type="text" placeholder="Name" aria-label="Name" autocomplete="name">
        </div>
        <div class="article-comment-form__field">
          <input type="email" placeholder="Email" aria-label="Email" autocomplete="email">
        </div>
      </div>

      <div class="article-comment-form__field article-comment-form__field--full">
        <textarea placeholder="Share your experience with your pet's routine." aria-label="Comment" rows="5"></textarea>
      </div>

      <button type="submit" class="article-comment-form__submit">Post comment</button>

    </form>

  </div>
</section>
```

---

## Task 3 — Add CSS to `article-styling.css`

Append to the end of `css/base/article-styling.css`:

```css
/* --------------------------------------------------------------------------
   COMMENTS SECTION
   -------------------------------------------------------------------------- */

.article-comments {
  background-color: var(--color-bg-base);
  padding: 72px var(--gutter);
}

.article-comments__inner {
  display: flex;
  flex-direction: column;
  gap: 40px;
  max-width: var(--container-inner);
  margin: 0 auto;
}

.article-comments__heading {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.article-comments__title {
  font-family: 'Syne', sans-serif;
  font-size: 42px;
  font-weight: var(--font-regular);
  line-height: 1.05;
  color: #2C2A2F;
  max-width: 600px;
}

.article-comments__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.article-comment-card {
  display: flex;
  flex-direction: column;
  gap: 12px;
  background-color: #ffffff;
  border: 1px solid var(--color-border);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-sm);
  padding: 24px;
}

.article-comment-card__author {
  font-family: var(--font-body);
  font-size: var(--text-base);
  font-weight: var(--font-semibold);
  color: #2C2A2F;
}

.article-comment-card__text {
  font-family: var(--font-body);
  font-size: var(--text-sm);
  line-height: 1.75;
  color: #5A575F;
}

/* --------------------------------------------------------------------------
   COMMENT FORM
   -------------------------------------------------------------------------- */

.article-comment-form {
  background-color: var(--color-bg-base);
  padding: 0 var(--gutter) 80px;
}

.article-comment-form__inner {
  display: flex;
  flex-direction: column;
  gap: 28px;
  max-width: var(--container-inner);
  margin: 0 auto;
  background-color: #ffffff;
  border: 1px solid var(--color-border);
  border-radius: var(--radius-xl);
  padding: 48px;
}

.article-comment-form__title {
  font-family: 'Syne', sans-serif;
  font-size: 34px;
  font-weight: var(--font-regular);
  color: #2C2A2F;
}

.article-comment-form__form {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.article-comment-form__row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.article-comment-form__field input,
.article-comment-form__field textarea {
  width: 100%;
  background-color: var(--color-bg-hero);
  border: 1px solid var(--color-border);
  border-radius: var(--radius-md);
  font-family: var(--font-body);
  font-size: var(--text-sm);
  color: var(--color-text-primary);
  padding: var(--space-4) var(--space-5);
  outline: none;
  transition: border-color var(--transition-fast);
  resize: none;
}

.article-comment-form__field input::placeholder,
.article-comment-form__field textarea::placeholder {
  color: var(--color-text-light);
}

.article-comment-form__field input:focus,
.article-comment-form__field textarea:focus {
  border-color: var(--color-accent);
}

.article-comment-form__submit {
  align-self: flex-start;
  background-color: var(--color-accent);
  border: none;
  border-radius: var(--radius-pill);
  color: #ffffff;
  cursor: pointer;
  font-family: var(--font-body);
  font-size: var(--text-sm);
  font-weight: var(--font-semibold);
  padding: var(--space-4) var(--space-10);
  transition: background-color var(--transition-fast);
}

.article-comment-form__submit:hover {
  background-color: var(--color-accent-dark);
}

/* --------------------------------------------------------------------------
   RESPONSIVE — Comments + Form (Tablet ≤ 1024px)
   -------------------------------------------------------------------------- */

@media (max-width: 1024px) {
  .article-comments {
    padding: 56px 40px;
  }

  .article-comments__title {
    font-size: var(--text-2xl);
  }

  .article-comments__grid {
    grid-template-columns: 1fr 1fr;
  }

  .article-comment-form {
    padding: 0 40px 60px;
  }

  .article-comment-form__inner {
    padding: 36px;
  }
}

/* --------------------------------------------------------------------------
   RESPONSIVE — Comments + Form (Mobile ≤ 600px)
   -------------------------------------------------------------------------- */

@media (max-width: 600px) {
  .article-comments {
    padding: 40px var(--space-5);
  }

  .article-comments__title {
    font-size: var(--text-xl);
  }

  .article-comments__grid {
    grid-template-columns: 1fr;
  }

  .article-comment-form {
    padding: 0 var(--space-5) 48px;
  }

  .article-comment-form__inner {
    padding: 24px var(--space-5);
  }

  .article-comment-form__row {
    grid-template-columns: 1fr;
  }

  .article-comment-form__title {
    font-size: var(--text-xl);
  }
}
```

---

## Design reference notes (from Paper)

- Comments background: same as page base (`--color-bg-base`)
- Comment cards: white, light border, subtle shadow — 3 columns desktop, 2 tablet, 1 mobile
- Comment form: white card with border, full-width inside page gutter
- Submit button: accent orange pill, left-aligned
- Name + Email: 2-column grid, collapses to 1 column on mobile
- Textarea: same input style as form fields, `rows="5"`

---

## After implementation

1. Run `ddev drush cr`
2. Visit any article at `/blog/<slug>` and verify comments + form render correctly
3. Resize to 768px and 390px to validate responsive behavior
