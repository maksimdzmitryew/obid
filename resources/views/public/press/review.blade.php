<div class="col-lg-4 col-12">
    <div class="news-item press-item releses-press">
        <div class="label-wrap">
            <div class="label">${category.name}</div>
        </div>
        {{--<div class="img-wrap">
            <!--<a><img src="${image.small_image_url}" alt="${image.name}"></a>-->
        </div>--}}
        <div class="descr">
            <h4 class="press-title"><a>${title}</a></h4>
            <div class="short">${description}</div>
        </div>
        <div class="date-box">
            <div class="date">${published_at}</div>
            <div class="name">${volume}</div>
        </div>
        <div class="download-link-wrap">
            <a href="${file}" class="btn download-btn">
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
        </div>
    </div>
</div>
