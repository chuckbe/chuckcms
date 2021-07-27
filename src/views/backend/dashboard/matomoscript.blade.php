<script>
    function str_pad_left(string,pad,length) {
        return (new Array(length+1).join(pad)+string).slice(-length);
    }
    
    $(function() {
        let start = moment().subtract(0, 'days');
        let end = moment();
        let _token = $('meta[name="csrf-token"]').attr('content');
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
                        // console.log(response.status);
                        // console.log(response.LastVisitsDetails);
                        $('#visitorcards').empty();
                        
                        $.each(response.LastVisitsDetails, function( index, value ) {
                            let tts = 0;
                            $.each(value.actionDetails,function(i,v){
                                if("timeSpent" in v){
                                    tts = parseInt(v.timeSpent, 10) + tts;
                                }
                            });
                            $("#visitorcards").append(`
                                <li class="card shadow my-3">
                                    <div class="card-body d-flex">
                                        <a class="visitor-log-visitor-profile-link visitorLogTooltip" data-visitor-id="${value.visitorId}">
                                            <i class="fa fa-id-card" aria-hidden="true"></i> <span>View visitor profile</span>
                                        </a>
                                        <div class="col-3 s12 m3">
                                            <strong 
                                                class="visitor-log-datetime visitorLogTooltip" 
                                                title="This visitor's last visit was ${parseInt(((value.secondsSinceLastVisit/60)/60)/24,10)} days ago.">
                                                ${value.serverDatePretty}
                                                - ${value.serverTimePretty}
                                            </strong>
                                            <span 
                                                class="visitor-log-ip-location visitorLogTooltip" 
                                                title="Visitor ID: ${value.visitorId}
                                                        Visit ID: ${value.idVisit}
                                                        ${value.location}
                                                        GPS (lat/long): ${value.latitude},${value.longitude}
                                                ">
                                                IP: ${value.visitIp}
                                                <br>
                                                <span>
                                                    <img width="16" class="flag" src="https://analytics.chuck.be/${value.countryFlag}">&nbsp;
                                                    ${value.city}
                                                </span>
                                            </span>
                                            ${value.referrerType == 'search' ? `<div class="visitorReferrer search"><span title="${value.referrerKeyword}"><img class="mr-2" width="16" src="https://analytics.chuck.be/${value.referrerSearchEngineIcon}" alt="${value.referrerName}"><span>${value.referrerName}</span></span></div>` : ''}
                                            ${value.referrerType == 'direct' ? `<div class="visitorReferrer direct">Direct Entry</div>` : ''}
                                            ${value.referrerType == 'website' ? `<div class="visitorReferrer website"><span>Website: </span><a href="${value.referrerUrl}" rel="noreferrer noopener" target="_blank" class="visitorLogTooltip" title="${value.referrerUrl}" style="text-decoration:underline;">${value.referrerName}</a></div>` : ''}
                                            ${value.sessionReplayUrl !== null ? `<a class="visitorLogReplaySession" href="https://analytics.chuck.be/index.php${value.sessionReplayUrl}" target="_blank" rel="noreferrer noopener"><i class="far fa-play-circle"></i> Replay recorded session</a>` : ''}
                                        </div> 
                                        <div class="col s12 m2 own-visitor-column"> 
                                            <span class="visitorLogIcons">
                                                <span class="visitorDetails">
                                                    ${value.visitorType == 'returning' ? `<span class="visitorLogIconWithDetails visitorTypeIcon"><img src="https://analytics.chuck.be/${value.visitorTypeIcon}"><ul class="details"><li>Returning Visitor - ${value.visitCount > 1 ? value.visitCount + ' visits': value.visitCount + ' visit'}</li></ul></span>` : ``}
                                                    <span class="visitorLogIconWithDetails flag" profile-header-text="Warrenville">
                                                        <img src="https://analytics.chuck.be/${value.countryFlag}">
                                                        <ul class="details">
                                                            <li>Country: ${value.country}</li>
                                                            <li>Region: ${value.region}</li>                
                                                            <li>City: ${value.city}</li>                
                                                            <li>Browser language: ${value.language}</li>                                
                                                            <li>IP: ${value.visitIp}</li>
                                                            <li>Visitor ID: ${value.visitorId}</li>
                                                        </ul>
                                                    </span>
                                                    <span class="visitorLogIconWithDetails" profile-header-text="${value.browser}">
                                                        <img src="https://analytics.chuck.be/${value.browserIcon}">
                                                        <ul class="details">
                                                            <li>Browser: ${value.browser}</li>
                                                            <li>Browser engine: ${value.browserFamily}</li>
                                                            <li id="pluginlist_${index}" class="plugins">
                                                                Plugins:
                                                            </li>
                                                        </ul>
                                                    </span>
                                                    <span class="visitorLogIconWithDetails" profile-header-text="${value.operatingSystem}">
                                                        <img src="https://analytics.chuck.be/${value.operatingSystemIcon}">
                                                        <ul class="details">
                                                            <li>Operating system: ${value.operatingSystemName} ${value.operatingSystemVersion}</li>
                                                        </ul>
                                                    </span>
                                                    <span class="visitorLogIconWithDetails" profile-header-text="${value.resolution}">
                                                        <img src="https://analytics.chuck.be/${value.deviceTypeIcon}">
                                                        <ul class="details">
                                                            <li>Device type: ${value.deviceType}</li>
                                                            <li>Device brand: ${value.deviceBrand}</li>                
                                                            <li>Device model: ${value.deviceModel}</li>                
                                                            <li>Resolution: ${value.resolution}</li>            
                                                        </ul>
                                                    </span>
                                                </span>
                                            </span>
                                        </div>
                                        <div id="visitorActions_${index}" class="col-7 s12 m7 column">
                                            <strong>${value.actions > 1 ? value.actions + ' Actions' : value.actions + ' Action'}</stong>
                                        </div>
                                    </div>
                                </li>
                            `);
                            $.each(value.pluginsIcons,function(i,v){
                                $(`#visitorcards .card #pluginlist_${index}`).append(`
                                    <img width="16px" height="16px" src="https://analytics.chuck.be/${v.pluginIcon}" alt="${v.pluginName}">
                                `);
                            });
                            if(tts > 0){
                                let min = Math.floor(tts / 60);
                                let sec = tts - (Math.floor(tts / 60) * 60);
                                if(min <= 0){
                                    $(`#visitorcards .card #visitorActions_${index} strong`).append(` - ${sec}s`);
                                }else{
                                    if(sec > 0 ){
                                        $(`#visitorcards .card #visitorActions_${index} strong`).append(` - ${min} min ${sec}s`);
                                    }else{
                                        $(`#visitorcards .card #visitorActions_${index} strong`).append(` - ${min} min`);
                                    }
                                }
                            }
                            if(value.actions > 0){
                                $(`#visitorcards .card #visitorActions_${index}`).append(`
                                    <div class="visitor-log-page-list">
                                        <ol class="visitorLog actionList"> 
                                        </ol>
                                    </div>
                                `);
                            }
                            $.each(value.actionDetails, function(i,v){
                                if(v.type == 'action'){
                                    $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog`).append(`
                                        <li class="action folder" 
                                            title="
                                            ${v.serverTimePretty}
                                            ${v.subtitle}
                                            ${v.pageLoadTime !== undefined ? `Page load time: ${v.pageLoadTime}` : ''}
                                            ${v.timeSpentPretty !== undefined ? `Time on page: ${v.timeSpentPretty}` : ''}
                                            ">
                                            <div>
                                                <span class="truncated-text-line">${v.title}</span>
                                                <img src="https://analytics.chuck.be/${v.iconSVG}" class="action-list-action-icon action">
                                                <p>                  
                                                    <a 
                                                        href="${v.url}" 
                                                        rel="noreferrer noopener" 
                                                        target="_blank" 
                                                        class="action-list-url truncated-text-line">
                                                            ${v.url}
                                                    </a>
                                                </p>            
                                            </div>
                                        </li>
                                    `);
                                }else{
                                    if($(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog.actionList`).children('.action.folder').length > 0){
                                        if($(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog .pageviewActions#pageviewActions_${index}`).length > 0){
                                            $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog .pageviewActions#pageviewActions_${index} .actionList`).append(`
                                                <li class="action" 
                                                    title="${v.serverTimePretty}
                                                            ${v.subtitle}
                                                            ${v.timeSpentPretty !== undefined ? `Time on page: ${v.timeSpentPretty}` : ''}">
                                                    <div>
                                                        <img src="https://analytics.chuck.be/${v.iconSVG}" class="action-list-action-icon ${v.type}">
                                                        <a href="${v.url}" rel="noreferrer noopener" target="_blank" class="action-list-url truncated-text-line">
                                                            ${v.url}
                                                        </a>
                                                    </div>
                                                </li>
                                            `);
                                        }else{
                                            $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog`).append(`
                                                <li id="pageviewActions_${index}" class="pageviewActions last-action" data-view-count="${v.pageviewPosition}">
                                                    <ol class="actionList p-0">
                                                    </ol>
                                                </li>
                                            `);
                                            $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog .pageviewActions#pageviewActions_${index} .actionList`).append(`
                                                <li class="action" 
                                                    title="${v.serverTimePretty}
                                                            ${v.subtitle}
                                                            ${v.timeSpentPretty !== undefined ? `Time on page: ${v.timeSpentPretty}` : ''}">
                                                    <div>
                                                        <img src="https://analytics.chuck.be/${v.iconSVG}" class="action-list-action-icon ${v.type}">
                                                        <a href="${v.url}" rel="noreferrer noopener" target="_blank" class="action-list-url truncated-text-line">
                                                            ${v.url}
                                                        </a>
                                                    </div>
                                                </li>
                                            `);
                                        }
                                    }else{
                                        $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog.actionList`).append(`
                                            <li class="action" 
                                                title="${v.serverTimePretty}
                                                        ${v.subtitle}
                                                        ${v.timeSpentPretty !== undefined ? `Time on page: ${v.timeSpentPretty}` : ''}">
                                                <div>
                                                    <img src="https://analytics.chuck.be/${v.iconSVG}" class="action-list-action-icon ${v.type}">
                                                    <a href="${v.url}" rel="noreferrer noopener" target="_blank" class="action-list-url truncated-text-line">
                                                        ${v.url}
                                                    </a>
                                                </div>
                                            </li>                                         
                                        `)
                                    }
                                    
                                }
                            });
                            if($(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog .pageviewActions#pageviewActions_${index}`).length > 0){
                                let el = $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog .pageviewActions#pageviewActions_${index} .actionList`);
                                let lastchild = $(el).children('.action').last();
                                $(lastchild).addClass('last-action');
                            }
                        });
                    }
                },
                complete: function(){
                      let numberOfItems = $("#visitorcards .card").length;
                      let limitPerPage = 10;
                      let totalPages = Math.ceil(numberOfItems / limitPerPage);
                      let paginationSize = 7;
                      var currentPage;
                      function showPage(whichPage) {
                        if (whichPage < 1 || whichPage > totalPages) return false;
                        currentPage = whichPage;
                        $("#visitorcards .card").hide().slice((currentPage - 1) * limitPerPage, currentPage * limitPerPage)
                        .show()
                        $(".pagination li").slice(1, -1).remove();
                        let arr = getPageList(totalPages, currentPage, paginationSize);
                        arr.forEach(item => {
                            $("<li>", {class : 'page-item'})
                            .append($('<a>', {class : 'page-link', text: "1"}))
                            .insertBefore(".pagination #next-page");
                        })
                            $("<li>", {class : 'page-item'})
                                .append($('<a>', {class : 'page-link', text: "1"}))
                                .insertBefore(".pagination #next-page");
                        
                        
                        
                        // getPageList(totalPages, currentPage, paginationSize).forEach(item => {
                            // $("<li>")
                            // .addClass("page-item " + (item ? "current-page " : "") + (item === currentPage ? "active " : ""))
                            // .append(
                            //     $('a')
                            //     .addClass("page-link")
                            //     .attr({href: "javascript:void(0)"})
                            //     .text(item || "...")
                            // )
                            // .insertBefore("#next-page");
                        // });
                        return true;
                      }
                      $(".pagination").append(
                          $("<li>").addClass("page-item").attr({ id: "previous-page" })
                          .append(
                            $("<a>").addClass("page-link").attr({href: "javascript:void(0)"}).text("Prev")
                          ),
                          $("<li>").addClass("page-item").attr({ id: "next-page" })
                          .append(
                            $("<a>").addClass("page-link").attr({href: "javascript:void(0)"}).text("Next")
                          )
                      );
                      $("#visitorcards").show();
                      showPage(1);
                    //   $(document).on("click",".pagination li.current-page:not(.active)", function(){
                    //       return showPage(+$(this).text());
                    //   });
                    //   $("#next-page").on("click", function() {
                    //         return showPage(currentPage + 1);
                    //     });

                    //     $("#previous-page").on("click", function() {
                    //         return showPage(currentPage - 1);
                    //     });
                    //     $(".pagination").on("click", function() {
                    //         $("html,body").animate({ scrollTop: 0 }, 0);
                    //     });
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
        
        function liveVisitCounter(){
            $.ajax({
                url: "/reportingApi/livecounter",
                type: "get",
                data: {
                    _token: _token
                },
                success:function(response){
                    if(response.success == 'success'){
                        $('#LiveVisitors').text(response.liveCounter[0].visits);
                        $("#counter-visitor").text(response.liveCounter[0].visits > 1 ? response.liveCounter[0].visits + " visitors" : response.liveCounter[0].visits + " visitor");
                        $("#counter-actions").text(response.liveCounter[0].actions > 1 ? response.liveCounter[0].actions + " actions" : response.liveCounter[0].actions + " action");
                    }
                }
            });
        }
        liveVisitCounter();
        setTimeout(liveVisitCounter, 20000);

      
        $('a.visitor-log-visitor-profile-link').click(function(e){
            console.log('testt');
        });
    });
</script>