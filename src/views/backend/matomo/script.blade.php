<script>
    $(function() {
        let start = moment().subtract(0, 'days');
        let end = moment();
        let _token   = $('meta[name="csrf-token"]').attr('content');
        function str_pad_left(string,pad,length) {
            return (new Array(length+1).join(pad)+string).slice(-length);
        }
        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            let values = $('#reportrange span').html().split(" - ");
            if(values[0] == values[1]){
                if(moment().subtract(1, 'days').format('MMMM D, YYYY') == values[0]){
                    $('#reportrange span').html('Yesterday');
                }else{
                    $('#reportrange span').html('Today');
                }
            }
            
            let val = $('#reportrange span').text();
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
                url: "/dashboard/matomo/api",
                type: "post",
                data: {
                    value : convertedRange,
                     _token: _token
                },
                success:function(response){
                    if(response.success == 'success'){
                        $('#mVersion').text("(Matomo version"+response.matomoVersion + ")");
                        $.each(response.recodings, function( index, value ) {
                            console.log(value);
                            let options = {
                                month: 'short', 
                                day: 'numeric',
                                hour: 'numeric',
                                minute: 'numeric',
                                second: 'numeric'  
                            }
                            let st = new Date(value.server_time)
                            let ds = st.toLocaleDateString("nl-BE", options);
                            let server_time = ds;
                            let minutes = Math.floor((value.time_on_site)/ 60);
                            console.log(minutes);
                            let seconds = value.time_on_site - (minutes * 60);
                            $( ".sessions-table #table_body_sessions" ).append(`
                            <tr class="data-row">
								<td class="d-flex justify-content-between sessionurl" scope="row">${value.first_url}
                                    <a href="https://analytics.chuck.be/${value.sessionReplayUrl}" target="_blank" class="hide">
                                        <i class="fab fa-youtube text-success" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td scope="row">
                                    ${value.nb_pageviews}
                                </td>
                                <td scope="row">${server_time}</td>	
                                <td scope="row">${str_pad_left(minutes,'0',2)+':'+str_pad_left(seconds,'0',2)}</td>		
							</tr>
                            `);
                        });
                    }
                }
            });
            // $.ajax({
            //     url: "/dashboard/matomo/changerange",
            //     type: "post",
            //     data: {
            //         value : convertedRange,
            //         _token: _token
            //     },
            //     success:function(response){
            //         if(response.success == 'success'){
            //             console.log(response);
            //             $('#mVersion').text("(Matomo version"+response.matomoVersion + ")");
            //             $("#avgBouceRate").text(response.matomoSummary.bounce_rate);
            //             $("#totalVisits").text(response.matomoSummary.nb_visits);
            //             $("#avgTimeSpend").text(response.matomoSummary.avg_time_on_site/60 > 1 ? (response.matomoSummary.avg_time_on_site/60).toFixed(2) + " Minutes": (response.matomoSummary.avg_time_on_site/60).toFixed(2) + " Minute"); 
            //             $("#countriesList").html('');
            //             let uniqueVisitorsCanvas = $('<canvas/>',{
            //                 'class':'px-3',
            //                 id: 'chart-1-container-canvas'                   
            //             });
            //             $("#chartVisitors").html('');
            //             $('#searchenginereferer').html('');
            //             $("#PopularOs").html('');
            //             $("#chartVisitors").append(uniqueVisitorsCanvas);
            //             let chartData = {}
                        
            //             if(val !== 'Today'){
            //                 response.getSearchEngines.forEach((search)=>{
            //                     if(search.sum_daily_nb_uniq_visitors > 0){
            //                         $("#searchenginereferer").append(`<li><strong>${search.label} search:</strong> ${(search.sum_daily_nb_uniq_visitors > 1 ? search.sum_daily_nb_uniq_visitors+" Visitors" : search.sum_daily_nb_uniq_visitors+" Visitor")}</li>`);
            //                     }
            //                 });
            //                 response.matomoCountries.forEach((country)=>{
            //                     if(country.sum_daily_nb_uniq_visitors > 0){
            //                         $("#countriesList").append(`<li>${country.label}: ${(country.sum_daily_nb_uniq_visitors > 1 ? country.sum_daily_nb_uniq_visitors+" Visitors" : country.sum_daily_nb_uniq_visitors+" Visitor")}</li>`);
            //                     }
            //                 });
            //                 let visitors = [];
            //                 let dates = [];
            //                 $.each(response.matomoUniqueVisitors, function(){
            //                         visitors.push(this);
            //                 });
            //                 if(val == 'Yesterday'){
            //                     chartData = {
            //                         labels: ['Yesterday', 'today'],
            //                         datasets: [{
            //                                 labels: ['Yesterday', 'today'],
            //                                 data: visitors,
            //                                 fill: true,
            //                                 borderColor: 'rgb(75, 192, 192)',
            //                                 tension: 0.1
            //                         }]
            //                     }
            //                 }else{
                                
            //                     for (let key in response.matomoUniqueVisitors){
            //                         dates.push(key);
            //                     }
            //                     chartData = {
            //                         labels: dates,
            //                         datasets: [{
            //                                 labels: dates,
            //                                 data: visitors,
            //                                 fill: true,
            //                                 borderColor: 'rgb(75, 192, 192)',
            //                                 tension: 0.1
            //                         }]
            //                     }
            //                 }
            //                 response.getOSFamilies.forEach((os)=>{
            //                     switch(os.label) {
            //                         case "iOS":
            //                         case "Mac":
            //                         $("#PopularOs").append(`
            //                             <li><i class="fa fa-apple" aria-hidden="true"></i> ${os.label}: ${os.sum_daily_nb_uniq_visitors > 1 ?  os.sum_daily_nb_uniq_visitors+" Visitors" : os.sum_daily_nb_uniq_visitors+" Visitor"}</li>
            //                         `);
            //                         break;
            //                         case "Android":
            //                         $("#PopularOs").append(`
            //                             <li><i class="fa fa-android" aria-hidden="true"></i> ${os.label}: ${os.sum_daily_nb_uniq_visitors > 1 ?  os.sum_daily_nb_uniq_visitors+" Visitors" : os.sum_daily_nb_uniq_visitors+" Visitor"}</li>
            //                         `);
            //                         break;
            //                         case "Windows":
            //                         $("#PopularOs").append(`
            //                             <li><i class="fa fa-windows" aria-hidden="true"></i> ${os.label}: ${os.sum_daily_nb_uniq_visitors > 1 ?  os.sum_daily_nb_uniq_visitors+" Visitors" : os.sum_daily_nb_uniq_visitors+" Visitor"}</li>
            //                         `);
            //                         break;
            //                         case "GNU/Linux":
            //                         case "Unix":
            //                         $("#PopularOs").append(`
            //                             <li><i class="fa fa-linux" aria-hidden="true"></i> ${os.label}: ${os.sum_daily_nb_uniq_visitors > 1 ?  os.sum_daily_nb_uniq_visitors+" Visitors" : os.sum_daily_nb_uniq_visitors+" Visitor"}</li>
            //                         `);
            //                         break;
            //                         case "Chrome OS":
            //                         $("#PopularOs").append(`
            //                             <li><i class="fa fa-chrome" aria-hidden="true"></i> ${os.label}: ${os.sum_daily_nb_uniq_visitors > 1 ?  os.sum_daily_nb_uniq_visitors+" Visitors" : os.sum_daily_nb_uniq_visitors+" Visitor"}</li>
            //                         `);
            //                         break;
            //                         default:
            //                         $("#PopularOs").append(`
            //                             <li><i class="fa fa-question" aria-hidden="true"></i> ${os.label}: ${os.sum_daily_nb_uniq_visitors > 1 ?  os.sum_daily_nb_uniq_visitors+" Visitors" : os.sum_daily_nb_uniq_visitors+" Visitor"}</li>
            //                         `);
            //                     }
            //                 });

            //             }else{
            //                 response.getSearchEngines.forEach((search)=>{
            //                     if(search.nb_uniq_visitors > 0){
            //                         $('#searchenginereferer').append(`
            //                             <li><strong>${search.label} search:</strong> ${(search.nb_uniq_visitors > 1 ? search.nb_uniq_visitors+" Visitors" : search.nb_uniq_visitors+" Visitor")}</li>
            //                         `)
            //                     }
            //                 })
            //                 response.matomoCountries.forEach((country)=>{
            //                     if(country.nb_uniq_visitors > 0){
            //                         $("#countriesList").append(`<li>${country.label}: ${(country.nb_uniq_visitors > 1 ? country.nb_uniq_visitors+" Visitors" : country.nb_uniq_visitors+" Visitor")}</li>`);
            //                     }
            //                 });
            //                 chartData = {
            //                     labels: ['Today'],
            //                     datasets: [{
            //                         labels: 'Today',
            //                         data: [response.matomoUniqueVisitors],
            //                         fill: true,
            //                         borderColor: 'rgb(75, 192, 192)',
            //                         tension: 0.1
            //                     }]
            //                 }
            //                 response.getOSFamilies.forEach((os)=>{
            //                     switch(os.label) {
            //                         case "iOS":
            //                         case "Mac":
            //                         $("#PopularOs").append(`
            //                             <li><i class="fa fa-apple" aria-hidden="true"></i> ${os.label}: ${os.nb_uniq_visitors > 1 ?  os.nb_uniq_visitors+" Visitors" : os.nb_uniq_visitors+" Visitor"}</li>
            //                         `);
            //                         break;
            //                         case "Android":
            //                         $("#PopularOs").append(`
            //                             <li><i class="fa fa-android" aria-hidden="true"></i> ${os.label}: ${os.nb_uniq_visitors > 1 ?  os.nb_uniq_visitors+" Visitors" : os.nb_uniq_visitors+" Visitor"}</li>
            //                         `);
            //                         break;
            //                         case "Windows":
            //                         $("#PopularOs").append(`
            //                             <li><i class="fa fa-windows" aria-hidden="true"></i> ${os.label}: ${os.nb_uniq_visitors > 1 ?  os.nb_uniq_visitors+" Visitors" : os.nb_uniq_visitors+" Visitor"}</li>
            //                         `);
            //                         break;
            //                         case "GNU/Linux":
            //                         case "Unix":
            //                         $("#PopularOs").append(`
            //                             <li><i class="fa fa-linux" aria-hidden="true"></i> ${os.label}: ${os.nb_uniq_visitors > 1 ?  os.nb_uniq_visitors+" Visitors" : os.nb_uniq_visitors+" Visitor"}</li>
            //                         `);
            //                         break;
            //                         case "Chrome OS":
            //                         $("#PopularOs").append(`
            //                             <li><i class="fa fa-chrome" aria-hidden="true"></i> ${os.label}: ${os.nb_uniq_visitors > 1 ?  os.nb_uniq_visitors+" Visitors" : os.nb_uniq_visitors+" Visitor"}</li>
            //                         `);
            //                         break;
            //                         default:
            //                         $("#PopularOs").append(`
            //                             <li><i class="fa fa-question" aria-hidden="true"></i> ${os.label}: ${os.nb_uniq_visitors > 1 ?  os.nb_uniq_visitors+" Visitors" : os.nb_uniq_visitors+" Visitor"}</li>
            //                         `);
            //                     }
            //                 });
            //             }
            //             let chart1 = new Chart(uniqueVisitorsCanvas[0].getContext('2d'), {
            //                             type: 'line',
            //                             data: chartData,
            //                             options: {
            //                                 responsive: true,
            //                                 legend: {
            //                                     display: false
            //                                 },
            //                                 tooltips: {
            //                                     callbacks: {
            //                                     title: function() {}
            //                                     }
            //                                 }
            //                             }
            //                         });          
            //         }
            //     }
            // });
            
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
        (function liveVisitCounter(){
            $.ajax({
                url: "/dashboard/matomo/livevisit",
                type: "get",
                data: {
                    _token: _token
                },
                success:function(response){
                    if(response.success == 'success'){
                        // console.log(response);
                        $('#LiveVisitors').text(response.liveCounter[0].visits);
                        $("#counter-visitor").text(response.liveCounter[0].visits > 1 ? response.liveCounter[0].visits + " visitors" : response.liveCounter[0].visits + " visitor");
                        $("#counter-actions").text(response.liveCounter[0].actions > 1 ? response.liveCounter[0].actions + " actions" : response.liveCounter[0].actions + " action");
                    }
                }
            });
            setTimeout(liveVisitCounter, 20000);
        })();
        $('#settingsmodal .modal-dialog .modal-footer .btn[type="submit"]').on('click', function(){
            $('#matomodata').submit();
        });
        $('#table').bootstrapTable({
            data: data
        });
    });
</script>