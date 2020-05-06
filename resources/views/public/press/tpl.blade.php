<div class="d-none" id="div-tpl-press">
    {{--<div class="col-lg-4 col-12">--}}
        {{--<div class="news-item press-item releases-press">--}}
            {%if type_id === '' %}
            {%elif type_id == 13 %}
            @include('public.press.photo')
            {%elif type_id == 11 %}
            @include('public.press.review')
            {%elif type_id == 23 %}
            @include('public.press.video')
            {%/if%}



            {{--<div class="img-wrap">--}}
                {{--{%if type === 'photo' %}--}}
                {{--<div class="img-wrap">--}}
                    {{--<div class="label">${category.name}</div>--}}
                    {{--<a href="${url}"><img src="${image.url}" alt="${image.name}"></a>--}}
                {{--</div>--}}
                {{--{%elif type === 'video' %}--}}
                {{--<div class="img-wrap">--}}
                    {{--<div class="label">${category.name}</div>--}}
                    {{--<a><img src="${image.url}" alt="${image.name}"></a>--}}
                {{--</div>--}}
                {{--{%else%}--}}
                {{--<div class="label-wrap">--}}
                    {{--<div class="label">${type}</div>--}}
                {{--</div>--}}
                {{--{%/if%}--}}
            {{--</div>--}}
            {{--<div class="descr">--}}
                {{--<h4 class="press-title"><a href="${url}">${title}</a></h4>--}}
                {{--<div class="short">${description}</div>--}}
            {{--</div>--}}
            {{--<div class="date-box">--}}
                {{--<div class="date">${date}</div>--}}
                {{--<div class="name">${files}</div>--}}
            {{--</div>--}}
@php
/*
            <div class="download-link-wrap">
                {%if type === '' %}
                {%elif type === 'Xpress_releaseX' %}

                <a href="${link}" class="btn download-btn d-img">
                    <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="15.1579" height="18.0001" fill="black" fill-opacity="0" transform="translate(16) scale(-1 1)"/>
                        <rect width="11.2515" height="13.1997" fill="black" fill-opacity="0" transform="translate(14.0469) scale(-1 1)"/>
                        <rect width="11.2515" height="13.1997" fill="black" fill-opacity="0" transform="translate(14.0469) scale(-1 1)"/>
                        <path d="M2.95294 8.0508L3.78536 7.1508C4.01525 6.9024 4.41315 6.8784 4.67589 7.0956L7.15799 9.162V0.6C7.15799 0.2688 7.44094 0 7.78957 0H9.05273C9.40136 0 9.68431 0.2688 9.68431 0.6V9.162L12.1664 7.0956C12.4279 6.8784 12.8258 6.9024 13.0569 7.1508L13.8894 8.0496C14.1205 8.2992 14.094 8.6796 13.8313 8.898L8.83673 13.0512C8.59799 13.2492 8.24304 13.2492 8.00431 13.0512L3.01104 8.898C2.74831 8.6796 2.72178 8.2992 2.95294 8.0508Z" fill="#0E293C"/>
                        <rect width="15.1579" height="2.4" fill="black" fill-opacity="0" transform="translate(16 15.6001) scale(-1 1)"/>
                        <rect width="15.1579" height="2.4" fill="black" fill-opacity="0" transform="translate(16 15.6001) scale(-1 1)"/>
                        <path d="M1.47368 15.6001H15.3684C15.7171 15.6001 16 15.8689 16 16.2001V17.4001C16 17.7313 15.7171 18.0001 15.3684 18.0001H1.47368C1.12505 18.0001 0.842104 17.7313 0.842104 17.4001V16.2001C0.842104 15.8689 1.12505 15.6001 1.47368 15.6001Z" fill="#0E293C"/>
                    </svg>
                    <span class="text">{{ trans('general.download-all-images') }}</span>
                </a>

                {%elif type === 'XvideoX' %}
                <a href="${youtube_link}" class="btn download-btn d-video">
                    <span class="yb in-btn">
                        <svg width="17" height="12" viewBox="0 0 17 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="17" height="12" fill="black" fill-opacity="0"/>
                            <rect width="17" height="12" fill="black" fill-opacity="0"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.1523 0.367188C15.8809 0.564941 16.4531 1.14355 16.6504 1.87744C17.0137 3.21875 17 6.01416 17 6.01416C17 6.01416 17 7.05811 16.9199 8.17529C16.8691 8.88135 16.7852 9.6167 16.6504 10.1362C16.4531 10.8706 15.8809 11.4492 15.1523 11.647C13.8223 12 8.5 12 8.5 12C8.5 12 6.24023 12 4.29492 11.8979C3.25977 11.8438 2.31445 11.7603 1.84766 11.6328C1.12109 11.4351 0.546875 10.8564 0.349609 10.1226C0 8.79541 0 6 0 6C0 6 0 5.01123 0.0742188 3.92871C0.125 3.19531 0.208984 2.41895 0.349609 1.87744C0.546875 1.14355 1.13477 0.550781 1.84766 0.353027C3.17969 0 8.5 0 8.5 0C8.5 0 10.2461 0 11.9883 0.0688477C13.2871 0.120605 14.584 0.210449 15.1523 0.367188ZM11.2324 6L6.80664 8.56934V3.43066L11.2324 6Z" fill="#FF0000"/>
                        </svg>
                        <span class="text">{!! trans('general.youtube') !!}</span>
                    </span>
                    <span class="vm in-btn">
                        <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="16" height="14" fill="black" fill-opacity="0"/>
                            <rect width="16" height="14" fill="black" fill-opacity="0"/>
                            <path d="M15.9923 3.23888C15.9211 4.81438 14.8332 6.97174 12.7292 9.70983C10.5538 12.5701 8.71334 14 7.20773 14C6.2754 14 5.4858 13.1293 4.84131 11.3873C4.41059 9.79044 3.98035 8.19379 3.54978 6.59697C3.0709 4.85589 2.55746 3.98423 2.00849 3.98423C1.88881 3.98423 1.46993 4.23898 0.752805 4.74653L0 3.7655C0.789605 3.06361 1.56865 2.36189 2.33506 1.65919C3.38818 0.738575 4.17875 0.254441 4.70563 0.205494C5.95092 0.0845011 6.71732 0.945507 7.00501 2.78867C7.31589 4.77722 7.53093 6.01413 7.65189 6.49827C8.01077 8.14807 8.40565 8.97192 8.83718 8.97192C9.17206 8.97192 9.6751 8.4369 10.3458 7.36686C11.0159 6.2965 11.3748 5.48218 11.4233 4.92277C11.5186 3.99909 11.1596 3.53612 10.3458 3.53612C9.96278 3.53612 9.5679 3.62529 9.16166 3.80153C9.9479 1.19605 11.4503 -0.0692846 13.6679 0.0029236C15.3119 0.0517085 16.087 1.13031 15.9923 3.23888Z" fill="#32B8E8"/>
                        </svg>
                        <span class="text">{!! trans('general.video') !!}</span>
                    </span>
                </a>
                {%else%}
<!--
                <a href="${pdf_link}" class="btn download-btn">
                    <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="15.1056" height="18.0002" fill="black" fill-opacity="0" transform="translate(15.2246) scale(-1 1)"></rect>
                        <rect width="11.2127" height="13.1997" fill="black" fill-opacity="0" transform="translate(13.2798) scale(-1 1)"></rect>
                        <rect width="11.2127" height="13.1997" fill="black" fill-opacity="0" transform="translate(13.2798) scale(-1 1)"></rect>
                        <path d="M2.2241 8.0508L3.05365 7.1508C3.28275 6.9024 3.67927 6.8784 3.9411 7.0956L6.41465 9.162V0.6C6.41465 0.2688 6.69662 0 7.04405 0H8.30286C8.65029 0 8.93226 0.2688 8.93226 0.6V9.162L11.4058 7.0956C11.6664 6.8784 12.0629 6.9024 12.2933 7.1508L13.1228 8.0496C13.3532 8.2992 13.3267 8.6796 13.0649 8.898L8.0876 13.0512C7.84969 13.2492 7.49596 13.2492 7.25805 13.0512L2.282 8.898C2.02017 8.6796 1.99374 8.2992 2.2241 8.0508Z" fill="#FF0000"></path>
                        <rect width="15.1056" height="2.4" fill="black" fill-opacity="0" transform="translate(15.2246 15.6001) scale(-1 1)"></rect>
                        <rect width="15.1056" height="2.4" fill="black" fill-opacity="0" transform="translate(15.2246 15.6001) scale(-1 1)"></rect>
                        <path d="M0.748376 15.6001H14.5952C14.9426 15.6001 15.2246 15.8689 15.2246 16.2001V17.4001C15.2246 17.7313 14.9426 18.0001 14.5952 18.0001H0.748376C0.400947 18.0001 0.118975 17.7313 0.118975 17.4001V16.2001C0.118975 15.8689 0.400947 15.6001 0.748376 15.6001Z" fill="#FF0000"></path>
                    </svg>
                    <span class="text">{{ trans('general.download-pdf') }}</span>
                </a>
    -->
                {%/if%}
            </div>

*/
@endphp
        {{--</div>--}}
    {{--</div>--}}

</div>
