function submitForm( elem, form_type ) {

    if ( !elem.classList.contains('loading') ) {
        elem.classList.add('loading');

        let cont = elem.closest('.subscribe_form');
        let inputs = cont.querySelectorAll('.form_field');
        let confirmed = true;
        let payload = {'form_type': form_type };
        inputs.forEach( function ( input ) {
            if ( input.value === '') {
                confirmed = false;
            }
            if ( input.closest('.input_cont').classList.contains('error') ) {
                confirmed = false;
            }
            payload[input.name] = input.value;
        });

        if ( confirmed ) {
            let request_data = {
                'action': 'google_api',
                'command': 'writeToSheet',
                'payload': payload
            };
            ajaxPost(request_data).then(function ( answer ) {
                let overlay = cont.querySelector('.overlay');
                overlay.classList.add( answer['result'], 'show' );
                overlay.querySelector('.text').innerHTML = answer['message'];
                if ( answer['result'] === 'success' ) {
                    overlay.querySelector('.title').innerHTML = 'Всё супер';
                    elem.classList.remove('loading');
                } else if ( answer['result'] === 'error' ) {
                    overlay.querySelector('.title').innerHTML = 'Что-то пошло не так';
                    elem.classList.remove('loading');
                }
            });
        } else {
            elem.classList.remove('loading');
        }
    }
    
}