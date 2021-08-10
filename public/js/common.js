let     b_focus_status                  = null,
        a_check_focus                   = [],
        timepassed                      = 0,
        s_csrf_token                    = $('[name="csrf-token"]').attr('content'),
        s_reCAPTCHA                     = $('[name="g-recaptcha-response"]').val(),
        i_csrf_update_time              = 0,
        i_csrf_refresh_time             = 1000 * 60 * 60 * 2, // 2 hours
        i_reCAPTCHA_update_time         = 0,
        i_reCAPTCHA_refresh_time        = 1000 * 60 * 2, // 1 second * 60 = 1 minute * 2 = 2 minutes
        i_reCAPTCHA_version             = 3,
    //  let i_reCAPTCHA_version = {{ config('services.google.recaptcha.version') }};
        b_refresh_tokens                    = false
        ;

$(document).ready(function ()
{
    window.b_focus_status = document.hasFocus();

    checkFocus();
    setInterval(checkFocus, 200);

    if (b_refresh_tokens)
    {
        setInterval(refreshToken, 1000 * 60); // 1 min
    }

});

function checkFocus()
{
    if(document.hasFocus() == b_focus_status) return;

    b_focus_status = !b_focus_status;

    if (b_focus_status)
        for (i = 0; i < a_check_focus.length; i++)
        {
            a_check_focus[i]();
        }
}

function refreshToken(){
    timepassed = Math.round((Date.now() - i_csrf_update_time) / 1000) * 1000;
    if (timepassed < i_csrf_refresh_time || !b_focus_status) return true;

    $.get(s_route_csfr).done(function(token){
        // new token received
        if (s_csrf_token != token)
        {
            s_csrf_token = token; // update token with the new token
            $('[name="csrf-token"]').attr('content', s_csrf_token);
            $('[name="_token"]').attr('value', s_csrf_token);

            i_csrf_refresh_time = Date.now();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        }
    });

}
// check token and refresh after user return to the page
if (b_refresh_tokens)
{
    a_check_focus.push(refreshToken);
}
