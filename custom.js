jQuery(document).ready(function(){
	
	
	jQuery(function() {
		var ul = jQuery( '.products li:nth-child(1) .product-inner .woo-entry-inner' ), li = ul.children();
		li.slice(0,2).wrapAll( '<div class="first-li" />');
	});
	
	jQuery(function() {
		var ul = jQuery( '.products li:nth-child(2) .product-inner .woo-entry-inner' ), li = ul.children();
		li.slice(0,2).wrapAll( '<div class="first-li" />');
	});
	
	jQuery(function() {
		var ul = jQuery( '.products li:nth-child(3) .product-inner .woo-entry-inner' ), li = ul.children();
		li.slice(0,2).wrapAll( '<div class="first-li" />');
	});


    /**
     * Перевод мм в дюймы на странице товара
     */
    let inches_input = jQuery("input[name='size-inch']"),
        size_input = jQuery("input[name='size-mm']");
    
    jQuery(size_input).on('change', function() {
        change_inches(this.value);
    });
    
    jQuery(size_input).on('keyup', function() {
        change_inches(this.value);
    });
    
    jQuery(inches_input).on('change', function() {
        change_mm(this.value);
    });
    
    jQuery(inches_input).on('keyup', function() {
        change_mm(this.value);
    });

    function change_inches(size) {
        inches = (size / 25.4).toFixed(3);
        jQuery(inches_input).val(inches);
    }

    function change_mm(size) {
        mm = (size * 25.4).toFixed(3);
        jQuery(size_input).val(mm);
    }

    /**
     * Расчёт отступа для блока «Ваш заказ» на странице товара
     */
    let order_heading = jQuery('#order_heading'),
        your_order_heading = jQuery('#your_order_heading'),
        offset = order_heading.position();
        
    your_order_heading.attr('style', 'margin-top:' + (offset.top-286) + 'px');

    /**
     * Sticky header при скролле
     */
    jQuery(window).scroll(function(){
        let header = jQuery('#site-header'),
            placeholder = jQuery('#dummy-header'),
            mainMenu = jQuery('#menu-main-menu'),
            logoWrap = jQuery('#site-logo-inner'),
            logo = jQuery('.custom-logo'),
            navWrap = jQuery('#site-navigation-wrap'),
            scroll = jQuery(window).scrollTop();

        if (scroll >= 100) {
            header.addClass('sticky-top');
            placeholder.show();
        } else if (scroll == 0) {
            header.removeClass('sticky-top');
            placeholder.hide();
        };

        if (scroll >= 120) {
            header.addClass('sticky-top-expanded');
            mainMenu.addClass('menu-main-menu-sticky');
            logoWrap.addClass('site-logo-inner-sticky');
            logo.addClass('custom-logo-sticky');
            navWrap.addClass('site-navigation-wrap-sticky');
        }

        if (scroll == 0) {
            header.removeClass('sticky-top-expanded');
            header.removeClass('sticky-top-expanded-sticky');
            mainMenu.removeClass('menu-main-menu-sticky');
            logoWrap.removeClass('site-logo-inner-sticky');
            logo.removeClass('custom-logo-sticky');
            navWrap.removeClass('site-navigation-wrap-sticky');
        }
      });

    /**
     * Выводим информацию о сплавах под селектом на странице товара
     */
    let fusionWrap = jQuery('.form-control.splav_parent'),
        fusionInfoWrap = jQuery('<div class="wcpa_form_item" id="fusion_info">' +
                '<h6><strong>Информация о сплаве:</strong></h6>' +
                '<p>Рекомендуемые температурные диапазоны к применению: <span id="fusion_temps"></span> &deg;С<br />' +
                'Предел прочности: <span id="fusion_durability"></span> МПа<br />' +
                'ROD: <span id="fusion_rod"></span>  мг/см<sup>2</sup>/час</p>' +
            '</div>'),
        fusionInfo = {
            'sp-dt': {
                'temps': 'высокие температуры (длительное растворение) 100-120',
                'durability': '300-400',
                'rod': '<10'
            },
            'vp-vt': {
                'temps': 'высокие температуры 100-120',
                'durability': '>400',
                'rod': '10-40'
            },
            'vp-st': {
                'temps': 'средние температуры 20-60',
                'durability': '>400',
                'rod': '40-80'
            },
            'sp-st': {
                'temps': 'средние температуры 20-60',
                'durability': '300-400',
                'rod': '40-80'
            },
            'sp-nt': {
                'temps': 'низкие температуры 20-60',
                'durability': '300-400',
                'rod': '80-200'
            },
            'sp-snt': {
                'temps': 'низкие температуры (слабо-минерализированные среды) 10-20',
                'durability': '300-400',
                'rod': '200-400'
            },
            'np-unt': {
                'temps': 'низкие температуры 2-10',
                'durability': '150-300',
                'rod': '>400'
            },
        },
        fusionSelect = jQuery('select[name="splav"]');

        function currentFusion() {
            let fusion = fusionSelect.find(":selected").val();
            if (fusionInfo[fusion] && fusionInfo[fusion].temps) {
                let fusionTemps = jQuery('#fusion_temps'),
                    fusionDurability = jQuery('#fusion_durability'),
                    fusionRod = jQuery('#fusion_rod'),
                    tempsInfo = fusionInfo[fusion].temps,
                    durabilityInfo = fusionInfo[fusion].durability,
                    rodInfo = fusionInfo[fusion].rod;
                fusionTemps.text(tempsInfo);
                fusionDurability.text(durabilityInfo);
                fusionRod.text(rodInfo);
                fusionInfoWrap.fadeIn();
            } else {
                fusionInfoWrap.fadeOut();
            }

        }

        fusionSelect.on('change',() => {
            currentFusion();
        });

    jQuery(fusionWrap).after(fusionInfoWrap);
    currentFusion();
});