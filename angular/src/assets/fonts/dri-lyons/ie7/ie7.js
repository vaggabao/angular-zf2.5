/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referencing this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'dri-lyons\'">' + entity + '</span>' + html;
	}
	var icons = {
		'dri-accordion': '&#xe900;',
		'dri-accordion-close': '&#xe901;',
		'dri-accordion-open': '&#xe902;',
		'dri-account': '&#xe903;',
		'dri-account-add': '&#xe904;',
		'dri-apparel': '&#xe905;',
		'dri-arrow-right': '&#xe906;',
		'dri-arrow-left': '&#xe908;',
		'dri-arrow-down': '&#xe909;',
		'dri-arrow-up': '&#xe90a;',
		'dri-banners': '&#xe90b;',
		'dri-bottom-of-copy': '&#xe90c;',
		'dri-brochures': '&#xe90d;',
		'dri-call': '&#xe90e;',
		'dri-cart': '&#xe90f;',
		'dri-checkmark_circle': '&#xe915;',
		'dri-circle': '&#xe917;',
		'dri-contact-us': '&#xe918;',
		'dri-corner': '&#xe919;',
		'dri-gear-solid': '&#xe91a;',
		'dri-gear': '&#xe91b;',
		'dri-customer-review': '&#xe91c;',
		'dri-cut-to-size-stickers': '&#xe91d;',
		'dri-design-tool': '&#xe91e;',
		'dri-dislike': '&#xe91f;',
		'dri-double-gate-fold': '&#xe920;',
		'dri-double-parallel-fold': '&#xe921;',
		'dri-download-file': '&#xe922;',
		'dri-duplicate': '&#xe923;',
		'dri-faq': '&#xe924;',
		'dri-flyers': '&#xe925;',
		'dri-free-proof': '&#xe926;',
		'dri-french-fold': '&#xe927;',
		'dri-gate-fold': '&#xe928;',
		'dri-grid': '&#xe929;',
		'dri-half-fold': '&#xe97f;',
		'dri-hamburger': '&#xe980;',
		'dri-left-of-copy': '&#xe981;',
		'dri-like': '&#xe982;',
		'dri-list': '&#xe983;',
		'dri-live-chat': '&#xe984;',
		'dri-loading': '&#xe985;',
		'dri-log-in': '&#xe98d;',
		'dri-mailing-box': '&#xe98e;',
		'dri-mailing-services': '&#xe98f;',
		'dri-no-fold': '&#xe991;',
		'dri-not-important': '&#xe992;',
		'dri-order-now': '&#xe993;',
		'dri-oval': '&#xe994;',
		'dri-printing': '&#xe995;',
		'dri-best-seller': '&#xe996;',
		'dri-business-essentials': '&#xe997;',
		'dri-custom-quote': '&#xe998;',
		'dri-calendar': '&#xe999;',
		'dri-prod-labels': '&#xe99a;',
		'dri-marketing-essentials': '&#xe99b;',
		'dri-new': '&#xe99c;',
		'dri-packaging': '&#xe99d;',
		'dri-promo': '&#xe99e;',
		'dri-signs': '&#xe99f;',
		'dri-product-box': '&#xe9a0;',
		'dri-recent-search': '&#xe9a9;',
		'dri-rectangle': '&#xe9aa;',
		'dri-remove': '&#xe9ab;',
		'dri-reorder': '&#xe9ac;',
		'dri-right-of-copy': '&#xe9ad;',
		'dri-roll-fold': '&#xe9ae;',
		'dri-roll-stickers-stickers': '&#xe9af;',
		'dri-saved-design': '&#xe9b0;',
		'dri-search': '&#xe9b1;',
		'dri-secured-checkout': '&#xe9b2;',
		'dri-share-link': '&#xe9b3;',
		'dri-shipping-box': '&#xe9b4;',
		'dri-shipping': '&#xe9b5;',
		'dri-square': '&#xe9b6;',
		'dri-star-solid': '&#xe9b7;',
		'dri-question-circle': '&#xe9bb;',
		'dri-top-of-copy': '&#xe9bd;',
		'dri-track-order': '&#xe9be;',
		'dri-trifold': '&#xe9bf;',
		'dri-trifold-letterfold': '&#xe9c0;',
		'dri-upload-file': '&#xe9c1;',
		'dri-checkmark': '&#xe9c2;',
		'dri-exclamation': '&#xe9c4;',
		'dri-warning-triangle': '&#xe9c5;',
		'dri-close': '&#xe9c8;',
		'dri-z-fold': '&#xe9c9;',
		'dri-zoom-in': '&#xe9ca;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/dri-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
