/*!***************************************************
 * google-translate.js v1.0.3
 * https://Get-Web.Site/
 * author: Vitalii P.
 *****************************************************/

const googleTranslateConfig = {
    /* Original language */
    lang: "ru",
    /* The language we translate into on the first visit*/
    // langFirstVisit: 'en',
    domain: "hseipaa.kz"
};

function TranslateInit() {

    if (googleTranslateConfig.langFirstVisit && !Cookies.get('googtrans')) {
        TranslateCookieHandler("/auto/" + googleTranslateConfig.langFirstVisit);
    }

    var code = TranslateGetCode();
    if (document.querySelector('[data-google-lang="' + code + '"]') !== null) {
        document.querySelector('[data-google-lang="' + code + '"]').classList.add('language__img_active');
    }

    if (code == googleTranslateConfig.lang) {
        TranslateCookieHandler(null, googleTranslateConfig.domain);
    }

    new google.translate.TranslateElement({
        pageLanguage: googleTranslateConfig.lang,
    });

    TranslateEventHandler('click', '[data-google-lang]', function (e) {
        TranslateCookieHandler("/" + googleTranslateConfig.lang + "/" + e.getAttribute("data-google-lang"), googleTranslateConfig.domain);
        window.location.reload();
    });
}

function TranslateGetCode() {
    var lang = (Cookies.get('googtrans') != undefined && Cookies.get('googtrans') != "null") ? Cookies.get('googtrans') : googleTranslateConfig.lang;
    return lang.match(/(?!^\/)[^\/]*$/gm)[0];
}

function TranslateCookieHandler(val, domain) {
    Cookies.set('googtrans', val);
    Cookies.set("googtrans", val, {
        domain: "." + document.domain,
    });

    if (domain == "undefined") return;
    Cookies.set("googtrans", val, {
        domain: domain,
    });
    Cookies.set("googtrans", val, {
        domain: "." + domain,
    });
}

function TranslateEventHandler(event, selector, handler) {
    document.addEventListener(event, function (e) {
        var el = e.target.closest(selector);
        if (el) handler(el);
    });
}
