{{-- <script>
    function str_pad_left(string,pad,length) {
        return (new Array(length+1).join(pad)+string).slice(-length);
    }
    

    $(function() {
        $(document).on('click', '#sidebarMenu .nav-item a', function(e){
            e.preventDefault();
            $('#sidebarMenu .nav-item .sidebar-sub-menu li').each(function(index, el){
                if($(el).hasClass( "active" )){
                    $(el).removeClass("active");
                }
            });
        });
        $(document).on('click', '#sidebarMenu .nav-item .sidebar-sub-menu li', function(){
            let link = $(this).children('a').data('link');
            if(link == 'heatmap'){
                $('.menu-items-content .matomo-items #Heatmapcards .heatmapcard').each(function(index, el){
                    if($(el).hasClass( "active" )){
                        $(el).removeClass("active");
                    }
                });
                let hmn = $(this).children('a').data('heatmapname');
                $(`#Heatmapcards .heatmapcard[data-heatmap="${hmn}"]`).addClass("active");
            }
            $('.menu-items-content .matomo-items').each(function(index, el){
                if($(el).hasClass( "active" )){
                    $(el).removeClass("active");
                }
            });
            $('#sidebarMenu .nav-item .sidebar-sub-menu li').each(function(index, el){
                if($(el).hasClass( "active" )){
                    $(el).removeClass("active");
                }
            });
            let target = $(`.menu-items-content div[data-item='${link}']`);
            target.addClass("active");
            $(this).addClass("active");
        });
    });
    
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
                        $('#visitoroverviewcards #visitoroverview').empty();
                        // if(Object.keys(response.visitsSummary).length > 0){
                        //     if(convertedRange.range == 'Today' || convertedRange.range == 'Yesterday'){
                        //         let value = response.visitsSummary;
                        //         $('#visitoroverviewcards #visitsoverview').html(`<li><strong>${value.nb_visits}</strong> visits, <strong>${value.nb_uniq_visitors}</strong> unique visitors</li>`);
                        //     }else{
                        //         let visits;
                        //         let uniquevisits;
                        //         $.each(response.visitsSummary, function(index, value){
                        //             if(value.length > 0 || Object.keys(value).length > 0){
                        //                 if(visits === undefined){
                        //                     visits = value.nb_visits;
                        //                 }else{
                        //                     visits = visits + value.nb_visits;
                        //                 }
                        //                 if(uniquevisits === undefined){
                        //                     uniquevisits = value.nb_uniq_visitors;
                        //                 }else{
                        //                     uniquevisits = uniquevisits + value.nb_uniq_visitors;
                        //                 }
                        //             }
                        //         });
                        //         $('#visitoroverviewcards #visitsoverview').html(`<li><strong>${visits}</strong> visits, <strong>${uniquevisits}</strong> unique visitors</li>`);
                        //     }
                        // }else{
                        //     $('#visitoroverviewcards #visitsoverview').html(`<li><h2>Data not available</h2></li>`);
                        // }
                        $('#visitorcards').empty();
                        if(response.lastVisitsDetails.length > 0){
                            $.each(response.lastVisitsDetails, function( index, value ) {
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
                                            <div class="col-4 s12 m3">
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
                                            <div id="visitorActions_${index}" class="col-6 s12 m7 column">
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
                        }else{
                            $("#visitorcards").append(`<h2>Data not available</h2>`);
                            $("#visitorcards ").siblings('nav').remove();
                        }
                        $("#Heatmapcards").empty();
                        $('.sidebar-dropdown-menu').find('a[data-category="heatmaps"]').siblings('.sidebar-sub-menu').empty();
                        // if(response.heatMaps.length > 0){
                        //     $.each(response.heatMaps, function( index, value ) {
                        //         let el = $('.sidebar-dropdown-menu').find('a[data-category="heatmaps"]').siblings('.sidebar-sub-menu');
                        //         $(el).append(`<li><a class="text-dark" href="#" data-link="heatmap" data-heatmapName="${value.name}">${value.name}</a></li>`);
                        //         $('#Heatmapcards').append(`<li class="my-3 heatmapcard" data-heatmap="${value.name}"><iframe id="iframe_${value.name}" src="https://analytics.chuck.be/${value.heatmapViewUrl}"></iframe></li>`);
                        //         // console.log(`https://analytics.chuck.be/${value.heatmapViewUrl}`);
                        //         // if($(`#Heatmapcards #iframe_${value.name} .heatmapVis .heatmapWrapper .heatmapContainer`).children().length == 0){
                        //         //     window.location.href = `https://analytics.chuck.be/index.php?module=Login&action=logme&login=rawaldeep&password=ac22d9b4456bb00b36ed297172dea58f&url=http://matomo.local/dashboard`
                        //         // }
                        //     });
                           
                        // }else{
                        //     $("#Heatmapcards").append(`<h2>Data not available</h2>`);
                        // }
                    }
                },
                complete: function(){
                    let numberOfItems = $("#visitorcards .card").length;
                    let limitPerPage = 10;
                    let totalPages = Math.ceil(numberOfItems / limitPerPage);
                    let paginationSize = 7;
                    var currentPage;
                    function getPageList(totalPages, page, maxLength) {
                    if (maxLength < 5) throw "maxLength must be at least 5";
                    function range(start, end) {
                        return Array.from(Array(end - start + 1), (_, i) => i + start);
                    }
                    var sideWidth = maxLength < 9 ? 1 : 2;
                    var leftWidth = (maxLength - sideWidth * 2 - 3) >> 1;
                    var rightWidth = (maxLength - sideWidth * 2 - 2) >> 1;
                    if (totalPages <= maxLength) {
                        // no breaks in list
                        return range(1, totalPages);
                    }
                    if (page <= maxLength - sideWidth - 1 - rightWidth) {
                        // no break on left of page
                        return range(1, maxLength - sideWidth - 1)
                        .concat([0])
                        .concat(range(totalPages - sideWidth + 1, totalPages));
                    }
                    if (page >= totalPages - sideWidth - 1 - rightWidth) {
                        // no break on right of page
                        return range(1, sideWidth)
                        .concat([0])
                        .concat(
                            range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages)
                        );
                    }
                        // Breaks on both sides
                        return range(1, sideWidth)
                            .concat([0])
                            .concat(range(page - leftWidth, page + rightWidth))
                            .concat([0])
                            .concat(range(totalPages - sideWidth + 1, totalPages));
                    }
                    function showPage(whichPage) {
                        if (whichPage < 1 || whichPage > totalPages) return false;
                        currentPage = whichPage;
                        $("#visitorcards .card").hide().slice((currentPage - 1) * limitPerPage, currentPage * limitPerPage)
                        .show()
                        $(".pagination li").slice(1, -1).remove();
                        let arr = getPageList(totalPages, currentPage, paginationSize);
                        arr.forEach(item => {
                            $("<li>", {class : 'page-item ' + (item ? "current-page " : "") + (item === currentPage ? "active " : "")})
                            .append($('<a>', {class : 'page-link', href: "javascript:void(0)" ,text: item || "..."}))
                            .insertBefore(".pagination #next-page");
                        });
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
                    $(document).on("click",".pagination li.current-page:not(.active)", function(){
                        return showPage(+$(this).text());
                    });
                    $("#next-page").on("click", function() {
                        return showPage(currentPage + 1);
                    });
                    $("#previous-page").on("click", function() {
                        return showPage(currentPage - 1);
                    });
                    $(".pagination").on("click", function() {
                        $("html,body").animate({ scrollTop: 0 }, 0);
                    });
                }
            });
            
           
        }
        
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'This Week': [moment().startOf('week'), moment().endOf('Week')],
            'Last Week': [moment().subtract(1, 'weeks').startOf('week'), moment().subtract(1, 'weeks').endOf('Week')],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'months').startOf('month'), moment().subtract(1, 'months').endOf('month')],
            'This Year': [moment().startOf('year'), moment().endOf('year')],
            'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
            }
        }, cb);
        cb(start, end);
        
        // function liveVisitCounter(){
        //     $.ajax({
        //         url: "/reportingApi/livecounter",
        //         type: "get",
        //         data: {
        //             _token: _token
        //         },
        //         success:function(response){
        //             if(response.success == 'success'){
        //                 $('#LiveVisitors').text(response.liveCounter[0].visits);
        //                 $("#counter-visitor").text(response.liveCounter[0].visits > 1 ? response.liveCounter[0].visits + " visitors" : response.liveCounter[0].visits + " visitor");
        //                 $("#counter-actions").text(response.liveCounter[0].actions > 1 ? response.liveCounter[0].actions + " actions" : response.liveCounter[0].actions + " action");
        //             }
        //         }
        //     });
        // }
        // liveVisitCounter();
        // setTimeout(liveVisitCounter, 20000);

        $(document).on('click','a.visitorLogTooltip',function(){
            //  $(this) = your current element that clicked.
            // additional code
            let visitorId = $(this).data("visitor-id");
            $.ajax({
                url: "/reportingApi/visitorsummary",
                type: "post",
                data: {
                    visitorid: visitorId,
                    _token: _token
                },
                success:function(response){
                    console.log(response.visitorProfile);
                    if(response.success == 'success'){
                        $('.modal-visitor-profile-info').attr('id', visitorId);
                        $('<span>', {text: visitorId+" "}).append('.visitor-profile-overview .visitor-profile-header .visitor-profile-id');
                        // if(response.visitorProfile.totalVisits > 1){
                        //     $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').append(`
                        //         <span class="visitorLogIconWithDetails visitorTypeIcon">
                        //             <img src="https://analytics.chuck.be/plugins/Live/images/returningVisitor.png">
                        //             <ul class="details">
                        //                 <li>Returning Visitor - ${response.visitorProfile.totalVisits} visits</li>
                        //             </ul>
                        //         </span>
                        //     `)
                        // }
                        $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').append(`
                            <span class="visitorLogIconWithDetails flag" profile-header-text="${response.visitorProfile.countries[0].cities[0]}">
                                <img src="https://analytics.chuck.be/${response.visitorProfile.countries[0].flag}">
                                <ul class="details">
                                    <li>Country: ${response.visitorProfile.countries[0].prettyName}</li>
                                    <li>City: ${response.visitorProfile.countries[0].cities[0]}</li>                
                                    <li>Browser language: ${response.visitorProfile.lastVisits[0].language}</li>                                
                                    <li>IP: ${response.visitorProfile.lastVisits[0].visitIp}</li>
                                    <li>Visitor ID: ${response.visitorProfile.lastVisits[0].visitorId}</li>
                                </ul>
                            </span>
                        `);
                        $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').append(`
                            <span class="visitorLogIconWithDetails" profile-header-text="${response.visitorProfile.lastVisits[0].browser}">
                                <img src="https://analytics.chuck.be/${response.visitorProfile.lastVisits[0].browserIcon}">
                                <ul class="details">
                                    <li>Browser: ${response.visitorProfile.lastVisits[0].browser}</li>
                                    <li>Browser engine: ${response.visitorProfile.lastVisits[0].browserFamily}</li>
                                    <li id="pluginlist_modal${visitorId}" class="plugins">
                                        Plugins:
                                    </li>
                                </ul>
                            </span>
                        `);
                        $.each(response.visitorProfile.lastVisits[0].pluginsIcons,function(i,v){
                            $(`#pluginlist_modal${visitorId}`).append(`
                                <img width="16px" height="16px" src="https://analytics.chuck.be/${v.pluginIcon}" alt="${v.pluginName}">
                            `);
                        });
                        $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').append(`
                            <span class="visitorLogIconWithDetails" profile-header-text="${response.visitorProfile.lastVisits[0].operatingSystem}">
                                <img src="https://analytics.chuck.be/${response.visitorProfile.lastVisits[0].operatingSystemIcon}">
                                <ul class="details">
                                    <li>Operating system: ${response.visitorProfile.lastVisits[0].operatingSystem}</li>
                                </ul>
                            </span>
                        `);
                        $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').append(`
                            <span class="visitorLogIconWithDetails" profile-header-text="${response.visitorProfile.lastVisits[0].resolution}">
                                <img src="https://analytics.chuck.be/${response.visitorProfile.lastVisits[0].deviceTypeIcon}">
                                <ul class="details">
                                    <li>Device type: ${response.visitorProfile.lastVisits[0].deviceType}</li>
                                    <li>Device brand: ${response.visitorProfile.lastVisits[0].deviceBrand}</li>                
                                    <li>Device model: ${response.visitorProfile.lastVisits[0].deviceModel}</li>                
                                    <li>Resolution: ${response.visitorProfile.lastVisits[0].resolution}</li>
                                </ul>
                            </span>
                        `);
                        $('.modal-visitor-profile-info .visitor-profile-summary .summary').html(`
                            <p>
                            Spent a total of <strong>1 min 10s</strong> on the website, and viewed 
                            <strong title="9 Unique Pageviews, 0 Pages viewed more than once">9 pages</strong> 
                            in <strong>2 visits</strong>.
                            </p>
                        `)
                        
                        $(`#${visitorId}`).modal({
                            show: true
                        });
                    }
                }
            });
        });
         $('.modal-visitor-profile-info').on('hidden.bs.modal', function(){
             $('.modal-visitor-profile-info').removeAttr('id');
             $('.modal-visitor-profile-info .modal-body .visitor-profile-overview .visitor-profile-header .visitor-profile-id span:last-of-type').remove();
             $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').empty();
         });
    });
</script> --}}