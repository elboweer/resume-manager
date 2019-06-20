/*

Project     : DAdmin - Responsive Bootstrap HTML Admin Dashboard
Version     : 1.1
Author      : ThemeLooks
Author URI  : https://themeforest.net/user/themelooks

*/

(function ($) {

    let location = window.location.href.toString().split(window.location.host)[1];

    $('.main-menu-item').each(function () {
        let link = $(this).attr('href');

        if (location == link) {
            $(this).parent().addClass('active');
            $(this).closest('.menu-items-group').addClass('open');
        }
    });


    $('a.remove-item').on('click', function (event) {
        event.preventDefault();

        let targetUrl = $(this).attr('href');

        Swal.fire({
            title: Translator.trans('action.confirmation.request'),
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            width: '27rem',
            cancelButtonText: Translator.trans('action.confirmation.cancel'),
            confirmButtonText: Translator.trans('action.confirmation.confirm')
        }).then((result) => {
            if (result.value) {
                window.location.href = targetUrl;
            }
        })


    });

    "use strict";

    /* ------------------------------------------------------------------------- *
     * COMMON VARIABLES
     * ------------------------------------------------------------------------- */
    var $body = $('body');

    $(function () {
        /* ------------------------------------------------------------------------- *
         * RECORDS LIST
         * ------------------------------------------------------------------------- */
        var $recordsList = $('.records--list'),
            $recordsListView = $('#recordsListView');

        if ($recordsListView.length) {
            $recordsListView.DataTable({
                responsive: true,
                stateSave: true,
                language: {
                    "processing": "Подождите...",
                    "search": "Поиск:",
                    "lengthMenu": "Показать _MENU_ записей",
                    "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
                    "infoEmpty": "Записи с 0 до 0 из 0 записей",
                    "infoFiltered": "(отфильтровано из _MAX_ записей)",
                    "infoPostFix": "",
                    "loadingRecords": "Загрузка записей...",
                    "zeroRecords": "Записи отсутствуют.",
                    "emptyTable": "В таблице отсутствуют данные",
                    "paginate": {
                        "first": "Первая",
                        "previous": "Предыдущая",
                        "next": "Следующая",
                        "last": "Последняя"
                    },
                    "aria": {
                        "sortAscending": ": активировать для сортировки столбца по возрастанию",
                        "sortDescending": ": активировать для сортировки столбца по убыванию"
                    }
                },
                dom: '<"topbar"<"toolbar"><"right"li>><"table-responsive"t>p',
                order: [],
                columnDefs: [
                    {
                        targets: 'not-sortable',
                        orderable: false
                    }
                ]
            });

            $recordsList.find('.toolbar').text($recordsList.data('title'));
        }

        /* ------------------------------------------------------------------------- *
         * SIDEBAR NAVIGATION
         * ------------------------------------------------------------------------- */
        var $sidebarNav = $('.sidebar--nav');

        $.each($sidebarNav.find('li'), function () {
            var $li = $(this);

            if ($li.children('a').length && $li.children('ul').length) {
                $li.addClass('is-dropdown');
            }
        });

        $sidebarNav.on('click', '.is-dropdown > a', function (e) {
            e.preventDefault();

            var $el = $(this),
                $es = $el.siblings('ul'),
                $ep = $el.parent(),
                $ps = $ep.siblings('.open');

            if ($ep.parent().parent('.sidebar--nav').length) {
                $es.slideToggle();
                $ep.toggleClass('open');

                return;
            }

            $es.add($ps.children('ul')).slideToggle();
            $ep.add($ps).toggleClass('open');
        });

        /* ------------------------------------------------------------------------- *
         * TOGGLE SIDEBAR
         * ------------------------------------------------------------------------- */
        var $toggleSidebar = $('[data-toggle="sidebar"]');

        $toggleSidebar.on('click', function (e) {
            e.preventDefault();

            $body.toggleClass('sidebar-mini');
        });

        $('.js-remove-sub').on('click', function(e) {
            e.preventDefault();
            $(this).closest('.js-sub-item')
                .fadeOut('slow')
                .remove();
        });


        $('.add-another-collection-widget').click(function (e) {
            var list = jQuery(jQuery(this).attr('data-list-selector'));
            var counter = list.data('widget-counter') | list.children().length;

            var newWidget = list.attr('data-prototype');

            newWidget = newWidget.replace(/__name__/g, counter);

            counter++;

            list.data('widget-counter', counter);

            var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
            newElem.addClass('');
            newElem.appendTo(list);

            $('.js-remove-sub').on('click', function(e) {
                e.preventDefault();
                $(this).closest('.js-sub-item')
                    .fadeOut('slow')
                    .remove();
            });
        });
    });

}(jQuery));
