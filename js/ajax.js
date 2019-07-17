'use strict';

function objectToUrlParamsRecursive( obj, url_params = false, namespace = false ) {

    let urlParams = url_params ? url_params : '';
    let DataKey;

    obj.forEach( function ( key, val ) {

        DataKey = namespace ? namespace + '[' + key + ']' : key;

        if( typeof val === 'object' && !( val instanceof File ) ) {
            urlParams = objectToUrlParamsRecursive( val, urlParams, DataKey );
        } else {
            if ( urlParams === '' ) {
                urlParams = urlParams + DataKey + '=' + val.toString();
            } else {
                urlParams = urlParams + '&' + DataKey + '=' + val.toString();
            }

        }

    });

    return urlParams;

}

function ajaxPost( data = {}, silent = true, url = undefined ) {

    /** Look Description about url in head **/
    if ( typeof url === 'undefined' )    {
        if ( typeof ajaxurl !== 'undefined' ) {
            url = ajaxurl['url'] ? ajaxurl['url'] : ajaxurl;
        } else {
            url = location.protocol + '//' + location.hostname;
        }
    }

    let requestData;

    if ( typeof data === 'object') {
        requestData = objectToUrlParamsRecursive( data );
    }

    console.log('Sending to ' + url + ' \nthis data: \n' + requestData );

    return fetch( url, {
        method: 'POST',
        // mode: '*same-origin',
        // credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        // referrer: '*client',
        body: requestData
    }).then( function ( response ) {
        return response.json();
    }).then( function ( json ) {
        console.log( json );
        return json;
    })

}

function forEach() {
    if (!Object.prototype.forEach) {
        Object.defineProperty(Object.prototype, 'forEach', {
            value: function (callback, thisArg) {
                if (this == null) {
                    throw new TypeError('Not an object');
                }
                thisArg = thisArg || window;
                for ( var key in this) {
                    if (this.hasOwnProperty(key)) {
                        callback.call(thisArg, key, this[key], this);
                    }
                }
            }
        });
    }
}

forEach();