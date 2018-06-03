
/*
|----------------------------------------------------------------
| jQuery functionality for YouKnow
|----------------------------------------------------------------
*/
var jqYouKnow = function () {

    var hasCssProperty =function (property) {
        return property in document.head.style;
    }

    var modifyBodyClass = function () {
        if (hasCssProperty('transform')) {
            document.body.classList.add('csstransforms');
        }
        if (hasCssProperty('transition')) {
            document.body.classList.add('csstransitions');
        }
    };

    var headerDetails = function () {
        var header = jQuery('#header');
        var pub = {};
        pub.isPresent = function () {return header.length; };
        pub.getHeight = function () { return header.outerHeight(); };
        pub.getOffset = function () { return pub.isPresent() ? pub.getHeight() : 0; };

        return pub;
    };

    var setSidebarListeners = function () {
        
        //var touchSupport = false;
        var eventClick = 'click';
        var eventHover = 'mouseover mouseout';
        //var siteLoaded = false;
        var opened = false;
        var trigger_url = false;

        //Open / close the left side bar.
        jQuery('#menu-trigger').bind('click', function(event){
            jQuery('#content-container').toggleClass('active');
            jQuery('#sidemenu').toggleClass('active');
            if(opened){
                opened = false;
                setTimeout(function(){
                    jQuery('#sidemenu-container').removeClass('active');
                }, 450);
            } else {
                jQuery('#sidemenu-container').addClass('active');
                opened = true;
            }
        });

        //Open / close the right side bar.
        jQuery('#search-trigger').on('click', function(e) {
            e.preventDefault();
            jQuery('body').addClass('has-active-menu');
            jQuery('#sidebar-right-container').addClass('active');
        });

        jQuery('#profile-trigger').on('click', function (e) {
            e.preventDefault();
            jQuery('#youknow-top-menu-collapse').toggleClass('collapsed');
        });

        //Close the right side bar
        jQuery('.off-canvas-menu-right-close').on('click', function (e){
            e.preventDefault();
            jQuery('#sidebar-right-container').removeClass('active');
            jQuery('body').removeClass('has-active-menu');
        });
        
        //Handle the display of submenus within the left side bar.
        jQuery('.sidenav .menu-item-has-children > a').bind('click', function(event){
            event.preventDefault();
            event.stopPropagation();
            var $this = jQuery(this);
            var ul = $this.siblings('.sub-menu');
            var sidenavtriggerContainer = $this.siblings('.sidenav-child-container');
            var sidenavTrigger = sidenavtriggerContainer.find('sidenav-child-trigger');
            var ulChildrenHeight = ul.children().length * 46;

            if(!$this.hasClass('active')){
                $this.toggleClass('active');
                ul.toggleClass('active');
                sidenavtriggerContainer.toggleClass('active');
                ul.height(ulChildrenHeight + 'px');
            } else {
                $this.toggleClass('active');
                ul.toggleClass('active');
                sidenavtriggerContainer.toggleClass('active');
                ul.height(0);
            }
        });
    
    };

    var setCategoryToggles = function () {
        jQuery('.showhide').on('click', function (e) {
            e.preventDefault();
            var hpanel = jQuery(this).closest('div.dlh-panel');
            var icon = jQuery(this).find('i:first');
            var body = hpanel.find('div.panel-body');
            var footer = hpanel.find('div.panel-footer');
            body.slideToggle(300);
            footer.slideToggle(200);

            icon.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
            hpanel.toggleClass('').toggleClass('panel-collapse');

            if(hpanel.hasClass('panel-collapse')) {
                console.log('there is a collapse');
                hpanel.find('.fullscreen').hide();
            } else {
                hpanel.find('.fullscreen').show();
            }

            setTimeout(function () {
                hpanel.resize();
                hpanel.find('[id^=map-]').resize();
            }, 50);
        });

        jQuery('.dlh-panel-with-image .panel-heading').on('click', function (e) {
            e.preventDefault();
            var hpanel = jQuery(this).closest('div.dlh-panel');
            var body = hpanel.find('div.panel-body');
            var footer = hpanel.find('div.panel-footer');
            body.slideToggle(300);
            footer.slideToggle(200);

            hpanel.toggleClass('').toggleClass('panel-collapse');

            if(hpanel.hasClass('panel-collapse')) {
                hpanel.find('.fullscreen').hide();
            } else {
                hpanel.find('.fullscreen').show();
            }

            setTimeout(function () {
                hpanel.resize();
                hpanel.find('[id^=map-]').resize();
            }, 50);
        });
    };

    var findSearchFilterLabel = function (value) {
        value = value.trim();
        if (value == 'all') {
            return 'All YouKnow';
        } else {
            var label = null;
            if (DLH.home !== undefined) {
                if (DLH.home.departments && DLH.home.departments.length > 0) {
                    for (var j = 0; j < DLH.home.departments.length; j++) {
                        if (value == DLH.home.departments[j].name) {
                            label = DLH.home.departments[j].label;
                            break;
                        }
                    }
                }
            }
            if (label == null) {
                if (DLH.home !== undefined && DLH.home.departmentFields !== undefined) {
                    var filters = DLH.home.departmentFields.search_filters;
                    if (filters.length && filters.length > 0) {
                        for (var i = 0; i < filters.length; i++) {
                            var check = filters[i].filter.trim();
                            if (check == value) {
                                label = filters[i].filter_label;
                                break;
                            }
                        }    
                    } 
                }
            }
            if (label == null) {
                var strSplit = value.split('_');
                var str = strSplit.join(' ').split('-');
                for (var i = 0; i < str.length; i++) {
                    str[i].charAt(0).toUpperCase() + str[i].slice(1);
                }
                label = str.join(" ");
            }
            return label;
        }
    };

    var setSearchParams = function () {
        jQuery('#primarySearchToggle').dropdown();
        jQuery('input[name=youknow_search_filter]').on('change', function () {
                var value = jQuery('input[name=youknow_search_filter]:checked').val();
                var label = findSearchFilterLabel(value);
                jQuery('#activeSearchLabel').html(label);
            });
        jQuery('.primary-search-btn').on('click', function (e) {
            e.preventDefault();
            var form = jQuery(this).closest('.primary-search-form');
            var formData = form.serialize();         
            form.submit();
        });
    };

    var setBookmarkEvents = function (event) {
        if (typeof DLH === "undefined") {
            return;
        }

        var added_message = DLH.bookmarks.added_message;
        var delete_message = DLH.bookmarks.delete_message;

        jQuery(".lighthouse_add_bookmark").click( function() {
            var post_id = jQuery(this).attr('rel');
            var data = {
                action: 'bookmark_post',
                post_read: post_id
            };
            jQuery.post(DLH.ajaxurl, data, function(response) {
                alert(added_message);
                jQuery('.lighthouse_bookmark_control_'+post_id).toggle();
                if(jQuery('.upb-bookmarks-list').length > 0 ) {
                    var bookmark_data = {
                        action: 'insert_bookmark',
                        post_id: post_id
                    };
                    jQuery.post(DLH.ajaxurl, bookmark_data, function(bookmark) {
                        jQuery(bookmark).appendTo('.upb-bookmarks-list');
                        jQuery('.no-bookmarks').fadeOut();
                    });
                }
            });
            return false;
        });
        jQuery(".lighthouse_del_bookmark").click( function() {
            if(confirm(delete_message)) {
                var post_id = jQuery(this).attr('rel');
                var data = {
                    action: 'del_bookmark',
                    del_post_id: post_id
                };
                jQuery.post(DLH.ajaxurl, data, function(response) {
                    jQuery('.bookmark-'+post_id).fadeOut();
                    jQuery('.lighthouse_bookmark_control_'+post_id).toggle();
                });
            }
            return false;
        });
    };

    var scrollbar = function () {
        var $scrollbar = jQuery('.question-sidebar .list-wrap, .messages .list-wrap, .message-sb .list-wrap, .notification .list-wrap, .list-item-body, .table-wrap .tbody');
        $scrollbar.perfectScrollbar({
            maxScrollbarLength: 150,
        });
        $scrollbar.perfectScrollbar('update');
    };

    var scrollStyle = function () {
        scrollbar();
        jQuery(window).on('load', function() {
            if (jQuery('.content-bar').length > 0) {
                var  currentPosition =jQuery('.content-bar').find('.current').position().left;
                var  prevCurrentWidth =jQuery('.content-bar').find('.current').prev().width();
                setTimeout(function() {
                    jQuery('.content-bar').animate({
                        scrollLeft: currentPosition - prevCurrentWidth
                    }, 400);
                }, 100);
            }
        });
    }

    var shareSectionLink = function () {
        
    }


    return {
        init: function () {
            modifyBodyClass();
            setSidebarListeners();
            setCategoryToggles();
            scrollStyle();
            // shareSectionLink();
            headerDetails();
            setBookmarkEvents();
            setSearchParams();
        },
        setCategoryToggles: setCategoryToggles,
        setBookmarkEvents: setBookmarkEvents,
        scrollbar: scrollbar
    };
};


jQuery(document).ready(function () {
    window.jqyk = new jqYouKnow;
    jqyk.init();   
    
});

var myScroll;

function isPassive() {
    var supportsPassiveOption = false;
    try {
        addEventListener("test", null, Object.defineProperty({}, 'passive', {
            get: function () {
                supportsPassiveOption = true;
            }
        }));
    } catch(e) {}
    return supportsPassiveOption;
}


document.addEventListener('touchmove', function (e) { e.preventDefault(); }, isPassive() ? {
    capture: false,
    passive: false
} : false);

jQuery(window).on('load', function () {

    // var urlHash = window.location.href.split('#');
    // if (urlHash.length > 1) {
    //     var anchor = jQuery('#' + urlHash[1]).offset().top - 90;
    //     jQuery('html,body').animate({
    //         scrollTop: anchor
    //     }, 500);
    // }
})
