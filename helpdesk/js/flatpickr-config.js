document.addEventListener('DOMContentLoaded', function(){
    if (typeof flatpickr === 'undefined') return;

    flatpickr.localize(flatpickr.l10ns.pt);

    const defaultConfig ={
        locale: 'pt',
        dateFormat: 'd/m/Y',
        allowInput: true,
        disableMobile: false
    };

    // incializa todos os elementos  com classe .flatpickr

    document.querySelectorAll('.flatpickr').forEach(el => {
        const opts = { ...defaultConfig };
        if(el.dataset.mode === 'datetime'){
            opts.enableTIme = true;
            opts.time_24hr = true;
            opts.dateFormat = 'd/m/Y H:i';
        }

        if (el.dataset.mindate) opts.minDate = el.dataset.minDate;
        if (el.dataset.maxdate) opts.maxDate = el.dataset.maxDate;
        flatpickr(el, opts);
    });

    // inicializa elementos com data-flatpickr (atributo vazio = opções padrões)
    document.querySelectorAll('[data-flatpickr]').forEach(el => {
        if(el._flatpickr) return;
        const opts = { ...defaultConfig };
        try{
            if (el.dataset.flatpickrOptions) Object.assign(opts, JSON.parse(el.dataset.flatpickrOptions))
        } catch (e){}
        flatpickr(el, opts);
    });
});



// incializa Flatpickr em um elemento especifico (para uso dinâmico)
/** 
    @param {string|HTMLElemnt} selector
    @param {Object} options 
*/

function initFlatpickr(selector, options = {}){
    if (typeof flatpickr === 'undefined') return null;
    const el = typeof selector === 'string' ? document.querySelector(selector) : selector;
    if (!el) return null;
    const opts = {locate: 'pt', dateFormat: 'd/m/Y', allowInput: true, ...options };
    return flatpickr(el,opts);
}