$(function () {
    $(window).on('resize', function () {
        $('.footer').width($('.main').width());
    });

    $(window).trigger('resize');

    $('.revoke-access-button, .grant-access-button').on('click', function (event) {
        event.preventDefault();

        $(this).prop('disabled', true);
        $(this).text('');
        $(this).append('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>');

        var form = $(this).parents('.toggle-access-form');
        var url = form.attr('action');
        var token = form.find('#form__token').val();

        var button = $(this);
        $.ajax({
            method: 'POST',
            url: url,
            data: {'form[_token]': token}
        }).done(function (result) {
            button.find('.glyphicon').remove();
            button.prop('disabled', false);

            if (result.success) {
                if (button.hasClass('revoke-access-button')) {
                    button.removeClass('revoke-access-button');
                    button.addClass('grant-access-button');
                    button.removeClass('btn-danger');
                    button.addClass('btn-success');
                    button.text('nadaj dostęp');
                } else {
                    button.addClass('revoke-access-button');
                    button.removeClass('grant-access-button');
                    button.removeClass('btn-success');
                    button.addClass('btn-danger');
                    button.text('odbierz dostęp');
                }
            } else {
                if (button.hasClass('revoke-access-button')) {
                    button.text('odbierz dostęp');
                } else {
                    button.text('nadaj dostęp');
                }
            }
        });
    });

    var chartData;

    new Chart($('#attendance-chart').get(0).getContext('2d')).Doughnut(attendanceChartData, {animateScale: true});
    new Chart($('#grade-chart').get(0).getContext('2d')).Doughnut(gradeChartData, {animateScale: true});
    new Chart($('#class-chart').get(0).getContext('2d')).Doughnut(studentsByClassChartData, {animateScale: true});

    chartData = [
        {
            value: 80,
            color: "#46BFBD",
            highlight: "#5AD3D1",
            label: "Obecność"
        },
        {
            value: 20,
            color: "#F7464A",
            highlight: "#FF5A5E",
            label: "Nieobecność"
        }
    ];
    new Chart($('#teacher-chart').get(0).getContext('2d')).Doughnut(chartData, {
        animateScale: true
    });
});
