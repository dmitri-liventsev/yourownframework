(function ( $ ) {
    $.fn.profileVersions = function( options ) {
        var settings = $.extend({
            versions: [],
            form_div: undefined
        }, options );

        function HtmlEncode(s)
        {
            var el = document.createElement("div");
            el.innerText = el.textContent = s;
            s = el.innerHTML;
            return s;
        }
    };
}( jQuery ));