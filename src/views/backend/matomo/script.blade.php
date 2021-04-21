 <script>
//   $(function() {
//     let chartData1 = $('#legend-1-container').find("li");
//     let chartData2 = $('#legend-2-container').find("li");
//     let data = [];
//     let countryData = [];
//     $.each($(chartData1),function(){
//       data.push(parseInt($(this).text()));
//     });
//     $.each($(chartData2),function(){
//       countryData.push({
//         "country" : $(this).text(),
//         "daily_unique_visitors": parseInt($(this).attr("data-daily-uniq-visitors")),
//         "country_code": $(this).attr("data-code")
//         });
//     });
//     let countries = {
//       data: {
//         uniqueVisitors: {
//           name: 'visitors',
//           format: '{0} visitors',
//           thousandSeparator: '.'
//         }
//       },
//       applyData: 'uniqueVisitors',
//       values : {}
//     }
//     $.each($(chartData2),function(){
//       let d = {uniqueVisitors :  parseInt($(this).attr("data-daily-uniq-visitors"))};
//       countries['values'][$(this).attr("data-code").toUpperCase()] = d;
//     });

//     let days = ['Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vridag', 'Zaterdag', 'Zondag'];
//     let goBackDays = 7;
//     let yesterday = new Date()
//     yesterday.setDate(yesterday.getDate() - 1);
//     let daysSorted = [];
//     for(let i = 0; i < goBackDays; i++) {
//       let newDate = new Date(yesterday.setDate(yesterday.getDate() - 1));
//       daysSorted.push(days[newDate.getDay()]);
//     }
    
//     let chartFigure1 = $('#chart-1-container');
//     let chartFigure2 = $('#chart-2-container');
//     let uniqueVisitorsCanvas = $('<canvas/>',{
//                    'class':'px-3',
//                     id: 'chart-1-container-canvas'                   
//                 });
//     let countriesCanvas = $('<div/>',{
//                    'class':'px-3',
//                     id: 'chart-2-container-div'                   
//                 });
//     $(chartFigure1).append(uniqueVisitorsCanvas);
//     // $(chartFigure2).append(countriesCanvas);
//     let Chart1 = new Chart(uniqueVisitorsCanvas[0].getContext('2d'), {
//         type: 'line',
//         data: {
//             labels: daysSorted.reverse(),
//             datasets: [{
//                 label: 'unique visitors',
//                 data: data,
//                 borderWidth: 1
//             }]
//         },
//         options: {
//             responsive: true,
//             legend: {
//               display: false
//             },
//             tooltips: {
//               callbacks: {
//                 title: function() {}
//               }
//             }
//         }
//     });
//     let choosePeriod = $('.matomoIntroData #period').val();
//     $(`.matomoIntroData div[data-summary=${choosePeriod}]`).show();
//     $('.matomoIntroData #period').on('change', function(){
//       let period = $(this).val();
//       $.each($(`.matomoIntroData div[data-summary]`),function(){
//         $(this).hide();
//       });
//       $(`.matomoIntroData div[data-summary=${period}]`).show();
//     });

//     //   new svgMap({
//     //                   targetElementID: 'chart-2-container-div',
//     //                   countryNames: svgMapCountryNamesEN,
//     //                   data: countries,
//     //                   colorMin: '#FFF',
//     //                   colorMax: '#730B62',
//     //                   hideFlag: false,
//     //                   noDataText: 'Geen bezoekers'
//     //             });
    
    
//     //   map = $K.map(chartFigure2, 600, 400);
//     //   map.loadMap('/chuckbe/chuckcms/world.svg', function() {
//     //    map.addLayer({
//     //       id: "countries",
//     //       key: "iso3"
//     //     })
//     //   });
//   });
$(function() {
    let start = moment().subtract(0, 'days');
    let end = moment();
    let data = [];
    let days = ['Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vridag', 'Zaterdag', 'Zondag'];
    let goBackDays = 7;
    let yesterday = new Date()
    yesterday.setDate(yesterday.getDate() - 1);
    let daysSorted = [];
    for(let i = 0; i < goBackDays; i++) {
      let newDate = new Date(yesterday.setDate(yesterday.getDate() - 1));
      daysSorted.push(days[newDate.getDay()]);
    }
    function cb(start, end) {
        if(end.diff(start, 'days') > 0){
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }else{
            if(Math.round(moment.duration(end.diff(start)).asHours()) > 0){
                $('#reportrange span').html("Yesterday");
            }else{
                $('#reportrange span').html("Today");
            }
        }
        let val = $('#reportrange span').text();
        let _token   = $('meta[name="csrf-token"]').attr('content');
        let convertedRange = {};
        if(val=="Today"){
            convertedRange = {
                range: val,
                d1: moment().format('DD'),
                m1: moment().format('MM'),
                y1: moment().format('YYYY')
            }
        }else if(val == "Yesterday"){
            convertedRange = {
                range: val,
                d1: moment().format('DD'),
                m1: moment().format('MM'),
                y1: moment().format('YYYY'),
                d2: moment().subtract(1, 'days').format('DD'),
                m2: moment().subtract(1, 'days').format('MM'),
                y2: moment().subtract(1, 'days').format('YYYY'),
            }
        }else{
            let dates = val.split("-");
            convertedRange = {
                range: val,
                d1: moment(dates[1]).format('DD'),
                m1: moment(dates[1]).format('MM'),
                y1: moment(dates[1]).format('YYYY'),
                d2: moment(dates[0]).format('DD'),
                m2: moment(dates[0]).format('MM'),
                y2: moment(dates[0]).format('YYYY'),
            }
        }
        $.ajax({
            url: "/dashboard/matomo/changerange",
            type: "post",
            data: {
                value : convertedRange,
                _token: _token
            },
            success:function(response){
                if(response.success == 'success'){
                    $('#mVersion').text("(Matomo version"+response.matomoVersion + ")");
                    let avg_time_on_site = response.matomoSummary.avg_time_on_site/60 > 1 ? (response.matomoSummary.avg_time_on_site/60).toFixed(2) + " Minutes": (response.matomoSummary.avg_time_on_site/60).toFixed(2) + " Minute"; 
                    $("#avgBouceRate").text(response.matomoSummary.bounce_rate);
                    $("#totalVisits").text(response.matomoSummary.nb_visits);
                    let visitors = [];
                    $("#avgTimeSpend").text(avg_time_on_site);
                    $("#countriesList").html('');
                    response.matomoCountries.forEach((country)=>{
                        if(country.nb_visits > 0){
                            $("#countriesList").append(`<li>${country.label}: ${(country.nb_visits > 1 ? country.nb_visits+" Visitors" : country.nb_visits+" Visitor")}</li>`);
                        }
                    });
                    $.each(response.matomoUniqueVisitors, function(){
                        visitors.push(this);
                    });
                    let uniqueVisitorsCanvas = $('<canvas/>',{
                        'class':'px-3',
                        id: 'chart-1-container-canvas'                   
                    });
                    $("#chartVisitors").append(uniqueVisitorsCanvas);
                    const data = {
                        labels: daysSorted.reverse(),
                        datasets: [{
                            labels: 'visitors',
                            data: visitors,
                            fill: true,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    };
                    let Chart1 = new Chart(uniqueVisitorsCanvas[0].getContext('2d'), {
                        type: 'line',
                        data: data,
                        options: {
                            responsive: true,
                            legend: {
                                display: false
                            },
                            tooltips: {
                                callbacks: {
                                title: function() {}
                                }
                            }
                        }
                    });
                       
                }
            }
        });
    }
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
        }
    }, cb);
    cb(start, end);


});
  </script>