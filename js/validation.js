'use strict';
console.log('index is loaded...');

function debounce( func, delay){
    let lastTimeout;
    return function(){

        if( lastTimeout ) {
            clearTimeout( lastTimeout );
        }

        let args = Array.from( arguments );
        lastTimeout = setTimeout(function(){
            func.apply(null, args);
        }, delay);
    }
}

function validateEmail( elem ) {
    let value = elem.value;
    let cont = elem.closest('.input_cont');
    let comment = elem.closest('.input_cont').querySelector('.input_comment');

    if ( !value ) {
        console.log('Вы ничего не ввели');
        cont.classList.add('error');
        comment.innerHTML = 'Вы ничего не ввели';
    } else {
        if( value.length > 160) {
            console.log('Слишком длинный email');
            cont.classList.add('error');
            comment.innerHTML = 'Слишком длинный email';
        } else {
            if ( !IsValidEmail( value ) ) {
                console.log('Кажется вы ввели не существующий email');
                cont.classList.add('error');
                comment.innerHTML = 'Кажется вы ввели не существующий email';
            } else {
                console.log('Ok');
                cont.classList.add('success');
                comment.innerHTML = 'Ок';
            }
        }
    }

}

function validateName( elem ) {
    let value = elem.value;
    let cont = elem.closest('.input_cont');
    let comment = elem.closest('.input_cont').querySelector('.input_comment');

    if ( !value ) {
        console.log('Вы ничего не ввели');
        cont.classList.add('error');
        comment.innerHTML = 'Вы ничего не ввели';
    } else {
        if( value.length > 160) {
            console.log('Слишком длинное имя');
            cont.classList.add('error');
            comment.innerHTML = 'Слишком длинное имя';
        } else {
            console.log('Ok');
            cont.classList.add('success');
            comment.innerHTML = 'Ок';
        }
    }

}

const delayValidateEmail = debounce( validateEmail, 2400);
const delayValidateName = debounce( validateName, 2400);

function validateInput( elem, type ) {
    let cont = elem.closest('.input_cont');
    let comment = elem.closest('.input_cont').querySelector('.input_comment');
    if ( cont.classList.contains('success') ) {
        cont.classList.remove('success');
    }
    if ( cont.classList.contains('error') ) {
        cont.classList.remove('error');
    }
    comment.innerHTML = '';
    if ( type === 'email' ) {
        delayValidateEmail( elem );
    } else if ( type === 'name' ) {
        delayValidateName( elem );
    }

}

let validateTypes = {
    'email':    /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
    'name':     /^[A-ZА-ЯЁ\s-]*$/i,
};

function IsValidEmail( val ) {
    return validateTypes['email'].test( val );
}

function isValidName( val ) {
    if ( val.length > 0 ) {
        return validateTypes['name'].test( val );
    } else {
        return false
    }
}