/**
 * NAS Admin JavaScript
 */
(function($) {
    'use strict';

    // Admin tab switching
    $(document).on('click', '.nas-tab', function() {
        const $this   = $(this);
        const tabId   = $this.data('tab');
        const $parent = $this.closest('.wrap, .nas-admin-wrap');

        $this.siblings('.nas-tab').removeClass('active');
        $this.addClass('active');

        $parent.find('.nas-tab-content').removeClass('active');
        $parent.find('#tab-' + tabId).addClass('active');
    });

    // Confirm dangerous actions
    $(document).on('click', '[data-confirm]', function(e) {
        if (!confirm($(this).data('confirm'))) e.preventDefault();
    });

    // Auto-resize textareas
    $('textarea').on('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

})(jQuery);
