@if (!empty($settings->github))
<a class="ico" target="_blank" href="{{ $settings->github }}"><img class="grayscale filter-green" src="https://github.githubassets.com/pinned-octocat.svg" alt="github" title="github"></a>
@endif
@if (!empty($settings->linkedin))
<a class="ico" target="_blank" href="{{ $settings->linkedin }}"><img src="https://content.linkedin.com/content/dam/me/business/en-us/amp/brand-site/v2/bg/LI-Bug.svg.original.svg" alt="linkedin" title="linkedin"></a>
@endif
