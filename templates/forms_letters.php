<?php

if ( is_user_logged_in() ) {
    $user = get_user_by('ID', get_current_user_id() );
    $user_email = $user->user_email;
    $registered_users = SkyEng_FormOptions::getOption('deal');
    if ( $registered_users[$user_email] ) {
        $isUserSubscribed = true;
    } else {
        $isUserSubscribed = false;
    }

}

?>

<div class="subscribe_form blue_border">

    <div class="title">
        Учите английский для деловой переписки. Это бесплатно
    </div>

    <div class="sub_title">
        Email-курс о том, как эффективно общаться с коллегами и партнерами
    </div>

    <div class="input_area">

        <div class="input_cont">
            <input
                class="form_field"
                id="subscribe_holmes_name"
                type="text"
                name="user_name"
                placeholder="Ваше имя"
                oninput="validateInput( this, 'name' )"
                onfocusout="validateName( this )"
                required
            >
            <div class="input_comment"></div>
        </div>

        <div class="input_cont">
            <input
                class="form_field"
                id="subscribe_holmes_mail"
                type="text"
                name="user_email"
                placeholder="Email"
                required
                oninput="validateInput( this, 'email' )"
                onfocusout="validateEmail( this )"
            >
            <div class="input_comment"></div>
        </div>

        <div class="submit_button_cont">
            <div class="submit_button" onclick="submitForm( this, 'deal')">
                <span class="text">Подписаться</span>
                <div class="loader">
                    <svg id="loader" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 367.136 367.136">
                        <path d="M185.262,1.694c-34.777,0-68.584,9.851-97.768,28.488C59.1,48.315,36.318,73.884,21.613,104.126l26.979,13.119
                            c25.661-52.77,78.03-85.551,136.67-85.551c83.743,0,151.874,68.13,151.874,151.874s-68.131,151.874-151.874,151.874
                            c-49.847,0-96.44-24.9-124.571-65.042l53.219-52.964H0v113.365l39.14-38.953c13.024,17.561,29.147,32.731,47.731,44.706
                            c29.33,18.898,63.353,28.888,98.391,28.888c100.286,0,181.874-81.588,181.874-181.874S285.548,1.694,185.262,1.694z"/>
                    </svg>
                </div>
                <div class="submit_button_border"></div>
            </div>
            <div class="notation">Нажимая, я принимаю условия <a href="<?php echo get_home_url().'/agreement';?>">соглашения</a></div>
        </div>

    </div>

    <div class="overlay <?php if ( $isUserSubscribed ) { echo 'show error'; } ?>">
        <span class="close" onclick="this.closest('.overlay').classList.remove('show', 'success', 'error')">
            <svg id="close" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 41.756 41.756">
                <path d="M27.948,20.878L40.291,8.536c1.953-1.953,1.953-5.119,0-7.071c-1.951-1.952-5.119-1.952-7.07,0L20.878,13.809L8.535,1.465
                    c-1.951-1.952-5.119-1.952-7.07,0c-1.953,1.953-1.953,5.119,0,7.071l12.342,12.342L1.465,33.22c-1.953,1.953-1.953,5.119,0,7.071
                    C2.44,41.268,3.721,41.755,5,41.755c1.278,0,2.56-0.487,3.535-1.464l12.343-12.342l12.343,12.343
                    c0.976,0.977,2.256,1.464,3.535,1.464s2.56-0.487,3.535-1.464c1.953-1.953,1.953-5.119,0-7.071L27.948,20.878z"/>
            </svg>
        </span>
        <span class="message">
            <span class="icon_error">
                <svg xmlns="http://www.w3.org/2000/svg"  x="0px" y="0px" viewBox="0 0 27.963 27.963">
                    <path d="M13.983,0C6.261,0,0.001,6.259,0.001,13.979c0,7.724,6.26,13.984,13.982,13.984s13.98-6.261,13.98-13.984
                        C27.963,6.259,21.705,0,13.983,0z M13.983,26.531c-6.933,0-12.55-5.62-12.55-12.553c0-6.93,5.617-12.548,12.55-12.548
                        c6.931,0,12.549,5.618,12.549,12.548C26.531,20.911,20.913,26.531,13.983,26.531z"/>
                    <polygon points="15.579,17.158 16.191,4.579 11.804,4.579 12.414,17.158 		"/>
                    <path d="M13.998,18.546c-1.471,0-2.5,1.029-2.5,2.526c0,1.443,0.999,2.528,2.444,2.528h0.056c1.499,0,2.469-1.085,2.469-2.528
                        C16.441,19.575,15.468,18.546,13.998,18.546z"/>
                </svg>
            </span>
            <span class="icon_success">
                <svg id="check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 21 15">
                    <path class="a" d="M2.545,4.091,0,6.7,8.1,15,21,2.786,18.281,0,7.926,9.605Z"/>
                </svg>
            </span>
            <span class="title"><?php if ( $isUserSubscribed ) { echo 'Привет'; } ?></span>
            <span class="text"><?php if ( $isUserSubscribed ) { echo 'Вы уже подписаны на эту рассылку'; } ?></span>
        </span>
    </div>

</div>