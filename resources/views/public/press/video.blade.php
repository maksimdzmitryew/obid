<div class="col-lg-4 col-12">
    <div class="news-item press-item video-press">
        <div class="img-wrap">
            <div class="label">${category.name}</div>
            <!--<a><img src="${image.small_image_url}" alt="${image.name}"></a>-->
        </div>
        <div class="descr">
            <h4 class="press-title"><a>${title}</a></h4>
            <div class="short">${description}</div>
        </div>
        <div class="date-box">
            <div class="date">${published_at}</div>
            <div class="name">${volume}</div>
        </div>
        <div class="download-link-wrap">
            {%if links.youtube %}
            <a class="btn download-btn d-video">
                <span class="yb in-btn">
                    <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="17" height="12" fill="black" fill-opacity="0"/>
                    <rect width="17" height="12" fill="black" fill-opacity="0"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.1523 0.367188C15.8809 0.564941 16.4531 1.14355 16.6504 1.87744C17.0137 3.21875 17 6.01416 17 6.01416C17 6.01416 17 7.05811 16.9199 8.17529C16.8691 8.88135 16.7852 9.6167 16.6504 10.1362C16.4531 10.8706 15.8809 11.4492 15.1523 11.647C13.8223 12 8.5 12 8.5 12C8.5 12 6.24023 12 4.29492 11.8979C3.25977 11.8438 2.31445 11.7603 1.84766 11.6328C1.12109 11.4351 0.546875 10.8564 0.349609 10.1226C0 8.79541 0 6 0 6C0 6 0 5.01123 0.0742188 3.92871C0.125 3.19531 0.208984 2.41895 0.349609 1.87744C0.546875 1.14355 1.13477 0.550781 1.84766 0.353027C3.17969 0 8.5 0 8.5 0C8.5 0 10.2461 0 11.9883 0.0688477C13.2871 0.120605 14.584 0.210449 15.1523 0.367188ZM11.2324 6L6.80664 8.56934V3.43066L11.2324 6Z" fill="#FF0000"/>
                    </svg>
                    <span class="text">youtube</span>
                </span>
            </a>
            {%/if%}
            {%if links.vimeo %}
            <a class="btn download-btn d-video">
                <span class="vm in-btn">
                    <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="16" height="14" fill="black" fill-opacity="0"/>
                    <rect width="16" height="14" fill="black" fill-opacity="0"/>
                    <path d="M15.9923 3.23888C15.9211 4.81438 14.8332 6.97174 12.7292 9.70983C10.5538 12.5701 8.71334 14 7.20773 14C6.2754 14 5.4858 13.1293 4.84131 11.3873C4.41059 9.79044 3.98035 8.19379 3.54978 6.59697C3.0709 4.85589 2.55746 3.98423 2.00849 3.98423C1.88881 3.98423 1.46993 4.23898 0.752805 4.74653L0 3.7655C0.789605 3.06361 1.56865 2.36189 2.33506 1.65919C3.38818 0.738575 4.17875 0.254441 4.70563 0.205494C5.95092 0.0845011 6.71732 0.945507 7.00501 2.78867C7.31589 4.77722 7.53093 6.01413 7.65189 6.49827C8.01077 8.14807 8.40565 8.97192 8.83718 8.97192C9.17206 8.97192 9.6751 8.4369 10.3458 7.36686C11.0159 6.2965 11.3748 5.48218 11.4233 4.92277C11.5186 3.99909 11.1596 3.53612 10.3458 3.53612C9.96278 3.53612 9.5679 3.62529 9.16166 3.80153C9.9479 1.19605 11.4503 -0.0692846 13.6679 0.0029236C15.3119 0.0517085 16.087 1.13031 15.9923 3.23888Z" fill="#32B8E8"/>
                    </svg>
                    <span class="text">vimeo</span>
                </span>
            </a>
            {%/if%}
        </div>
    </div>
</div>
