# Contributing

Add one independent `.changelog/*.md` fragment for each observable change.
Use [Fast Forward Changelog](https://github.com/php-fast-forward/changelog)
through CPX with PHP 8.5 or newer; the package's PHP requirements stay unchanged.

```sh
cpx --skip-local fast-forward/changelog help add
cpx --skip-local fast-forward/changelog add "Describe the change." --category=fixed --no-interaction
cpx --skip-local fast-forward/changelog check --no-interaction
```

Choose the category and semantic impact that describe the change. Commit the
fragment with the contribution; leave published history intact and do not add
an `Unreleased` section to `CHANGELOG.md`. After committing, validate the PR delta
with `check --since=origin/main --source=github --no-interaction` using the same CLI.

Run `composer install` to fetch the project skill into
`.agents/skills/fast-forward-changelog`. The committed `skills.json` selects its
GitHub source through `llm/skills`; generated `.agents` files stay out of Git.
This does not install Changelog's runtime dependencies into the library.
Inspect the copy with `composer skills:show` and refresh compatible versions with
`composer skills:update --from=github`. Keep the skill under this manager's
ownership; do not run the legacy Changelog skill installer on it.

The GitHub workflow checks fragments, maintains PR feedback and prepares a
version PR from stable ancestral tags, existing GitHub Release notes and committed
history. Historical GitHub Release bodies are preserved in `CHANGELOG.md`; empty
release bodies are identified explicitly without invented change descriptions.
New entries can link to their originating PR automatically when GitHub evidence
is available.
Version PR titles use `chore(release): fast-forward/http-client v<current> → v<next>`.
Review that PR's version, history and fragment deletions before merging it.
It never merges itself;
its approved merge publishes the version tag and GitHub Release. Installing the
workflow or merging an ordinary contribution does not publish a release.

## Composer dependency skills

The development-only manager restores `fast-forward-container` and
`fast-forward-config` from the installed Composer packages, including Config as
a transitive dependency. `skills.json` explicitly trusts only those two Composer
donors; dependency trust does not extend to other installed packages. No separate
GitHub source or version pin is used for either library.

Inspect donors with `composer skills:show` and refresh their payloads with
`composer skills:update --from=composer`. The existing GitHub source continues
to manage the Changelog contributor skill independently. Generated copies remain
ignored. Synchronization does not upgrade runtime dependencies; an installed
version without a bundled skill contributes no skill. Check installed versions
and the bundled skill's supported contract before using its instructions.
