'use strict';

$(document).ready(function () {
    feather.replace();

    // tab
    $tabCard = $('.feature-card');
    $tabCard.on('click', function () {
        $this = $(this);
        var tabId = $this.data('tab');

        $tabCard.removeClass('active');
        $this.addClass('active');

        $('.tab-panel').hide();
        $('#' + tabId).show();
    });
});