<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    let matomoUrl = '{{ChuckSite::getSetting('integrations.matomo-site-url')}}'
    
    function str_pad_left(string,pad,length) {
        return (new Array(length+1).join(pad)+string).slice(-length);
    }
    function humanizeNumber(n) {
        n = n.toString()
        while (true) {
            var n2 = n.replace(/(\d)(\d{3})($|,|\.)/g, '$1,$2$3')
            if (n == n2) break
            n = n2
        }
        return n
    }

    function liveCounter(){
        $.ajax({
            url: "/dashboard/matomo/api/livecounter",
            type: "post",
            success:function(response){
                $('.menu-items-content #visitoroverviewcards #liveVisitors .simple-realtime-visitor-counter').html(`<span>${response.liveCounter[0].visitors}</span>`);
                $('.menu-items-content #visitoroverviewcards #liveVisitors .simple-realtime-elaboration').html(`<span><strong>${response.liveCounter[0].visits} visits</strong> and <strong>${response.liveCounter[0].actions} actions</strong> in the last <strong>3 minutes</strong></span>`);
            },
            complete: function(){
                setTimeout(liveCounter, 180000);
            }
        });
    }

    function visitData(){
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
            url: "/dashboard/matomo/api/overview",
            type: "post",
            data: {
                value : convertedRange
            },
            success:function(response){
                let visits = humanizeNumber(response.data.nb_visits);
                let uniquevisitors = humanizeNumber(response.data.nb_uniq_visitors);
                let avgTimeSpend = moment.utc(response.data.avg_time_on_site*1000).format('mm:ss').split(":");
                let bounceRate = response.data.bounce_rate;
                let actionsPerVisit = response.data.nb_actions_per_visit;
                let pageViews = humanizeNumber(response.data.nb_pageviews);
                let uniquePageViews = humanizeNumber(response.data.nb_uniq_pageviews);
                let totalSearches = humanizeNumber(response.data.nb_searches);
                let uniqueKeywords = humanizeNumber(response.data.nb_keywords);
                let downloads = humanizeNumber(response.data.nb_downloads);
                let uniqueDownloads = humanizeNumber(response.data.nb_uniq_downloads);
                let outlinks = humanizeNumber(response.data.nb_outlinks);
                let uniqueOutlinks = humanizeNumber(response.data.nb_uniq_outlinks);
                let maxActions = humanizeNumber(response.data.max_actions);
                
                $('.menu-items-content #visitoroverviewcards #visitsoverview').empty();
                $('.menu-items-content #visitoroverviewcards #visitsoverview').append(`
                    <div class="py-3 col-6"><img class="mr-3" style="width: auto;height: 45px;" src=${response.visitimg}>
                        <span><strong>${visits}</strong> visits, <strong>${uniquevisitors}</strong> unique visitors</span>
                    </div>
                    <div class="py-3 col-6"><img class="mr-3" style="width: auto;height: 45px;" src=${response.avgvisitimg}>
                            <span><strong>${avgTimeSpend[0]} min ${avgTimeSpend[1]}s</strong> average visit duration</span>
                    </div>
                    <div class="py-3 col-6"><img class="mr-3" style="width: auto;height: 45px;" src=${response.avgvisitimg}>
                            <span><strong>${bounceRate}</strong> visits have bounced (left the website after one page)</span>
                    </div>
                    <div class="py-3 col-6"><img class="mr-3" style="width: auto;height: 45px;" src=${response.actions_per_visit_img}>
                            <span><strong>${actionsPerVisit}</strong> actions (page views, downloads, outlinks and internal site searches) per visit</span>
                    </div>
                    <div class="py-3 col-6"><img class="mr-3" style="width: auto;height: 45px;" src=${response.pageviewimg}>
                            <span><strong>${pageViews}</strong> pageviews, <strong>${uniquePageViews}</strong> unique pageviews</span>
                    </div>
                    <div class="py-3 col-6"><img class="mr-3" style="width: auto;height: 45px;" src=${response.searchesandkeywordsimg}>
                            <span><strong>${totalSearches}</strong> total searches on your website, <strong>${uniqueKeywords}</strong> unique keywords</span>
                    </div>
                    <div class="py-3 col-6"><img class="mr-3" style="width: auto;height: 45px;" src=${response.downloadsimg}>
                            <span><strong>${downloads}</strong> downloads, <strong>${uniqueDownloads}</strong> unique downloads</span>
                    </div>
                    <div class="py-3 col-6"><img class="mr-3" style="width: auto;height: 45px;" src=${response.outlinksimg}>
                            <span><strong>${outlinks}</strong> outlinks, <strong>${uniqueOutlinks}</strong> unique outlinks</span>
                    </div>
                    <div class="py-3 col-6"><img class="mr-3" style="width: auto;height: 45px;" src=${response.maxactionsimg}>
                            <span><strong>${maxActions}</strong> max actions in one visit</span>
                    </div>
                `);
            }
        });
    }

    function getReferrers(){
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
            url: "/dashboard/matomo/api/overview/referrers",
            type: "post",
            data: {
                value : convertedRange
            },
            success:function(response){
                $('#referrers .referrerslist').empty();
                $.each(response.data ,  function(k, v){
                    $('#referrers .referrerslist').append(`<li class="py-2">
                        <div>
                            <img src="${matomoUrl}/${v.logo}" style="max-width: 15px">
                            <span>${v.label} :</span>
                            <span>${v.nb_uniq_visitors}</span>
                        </div>
                        
                    </li>`)
                });
            },
            complete: function(){
                
            }
        });
    }

    function getOverview(){
        liveCounter();
        visitData();
        getReferrers();
    }

    $(function() {
        $(document).on('click', '#sidebarMenu .nav-item a', function(e){
            e.preventDefault();
            $('#sidebarMenu .nav-item').each(function(index, el){
                if($(el).hasClass( "active" )){
                    $(el).removeClass("active");
                }
            });
            $(this).parent().addClass("active");
            $('#sidebarMenu .nav-item .sidebar-sub-menu li').each(function(index, el){
                if($(el).hasClass( "active" )){
                    $(el).removeClass("active");
                }
            });
            let category = $(this).data('category');
            switch(category) {
                case 'visitors':
                    $('#sidebarMenu .nav-item .sidebar-sub-menu li').each(function(index, el){
                        if($(el).hasClass( "active" )){
                            $(el).removeClass("active");
                        }
                    });
                    $('.menu-items-content .matomo-items').each(function(index, el){
                        if($(el).hasClass( "active" )){
                            $(el).removeClass("active");
                        }
                    });
                    $(`.menu-items-content div[data-item='overview']`).addClass("active");
                    $('#sidebarMenu .nav-item.active .sidebar-sub-menu li a[data-link="overview"]').parent().addClass("active");
                    getOverview();
                    break;
                default:
            }
        });
        $(document).on('click', '#sidebarMenu .nav-item .sidebar-sub-menu li', function(){
            let link = $(this).children('a').data('link');
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
            if(link == 'overview'){
                getOverview();
            }
        });
        let reportrangedate = document.querySelector('#reportrange span')
        let observer = new MutationObserver(function(mutations) {
            if(document.querySelector('[data-item="overview"]').classList.contains("active")){
                getOverview(); 
            }
            
        });
        let config = { attributes: true, childList: true, characterData: true };
        observer.observe(reportrangedate, config);
        
    });

    $(function() {
        let start = moment().subtract(0, 'days');
        let end = moment();

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
                },
                success:function(response){
                    $('#visitoroverviewcards #visitoroverview').empty();
                    $('#visitorcards').empty();
                    if(response.lastVisitsDetails.length > 0){
                        $.each(response.lastVisitsDetails, function( index, value ) {
                            let tts = 0;
                            $.each(value.actionDetails,function(i,v){
                                if("timeSpent" in v){
                                    tts = parseInt(v.timeSpent, 10) + tts;
                                }
                            });

                            $("#visitorcards").append(`<li class="card shadow my-3" data-log="${index}_${value.visitorId}">${response.htmlData}</li>`);
                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] a.visitor-log-visitor-profile-link`).attr('data-visitor-id', value.visitorId);
                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] strong.visitorLogTooltip`)
                            .attr('title', `This visitor's last visit was ${parseInt(((value.secondsSinceLastVisit/60)/60)/24,10)} days ago.`);
                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] strong.visitorLogTooltip`).text(`
                                ${value.serverDatePretty}
                                - ${value.serverTimePretty}
                            `);

                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] span.visitor-log-ip-location`)
                            .attr('title', `Visitor ID: ${value.visitorId} \n Visit ID: ${value.idVisit} \n ${value.location} \n GPS (lat/long): ${value.latitude},${value.longitude}
                            `);
                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] span.visitor-log-ip-location #visitip`).text(`
                                IP: ${value.visitIp}
                            `);
                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] span.visitor-log-ip-location #visitip`).css({
                                'font-size': "11px"
                            });
                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] span.visitor-log-ip-location span#visitor_city_span`).html(`
                                <img width="16" class="flag" src='${matomoUrl}/${value.countryFlag}'>&nbsp;
                                ${value.city}
                            `);

                            switch(value.referrerType) {
                                case 'search':
                                    $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .visitorreferencearea`).html(`
                                        <div class="visitorReferrer search">
                                            <span title="${value.referrerKeyword}">
                                                <img 
                                                    class="mr-2" 
                                                    width="16" 
                                                    src="${matomoUrl}/${value.referrerSearchEngineIcon}" 
                                                    alt="${value.referrerName}">
                                                <span>${value.referrerName}</span>
                                            </span>
                                        </div>
                                    `);
                                    break;
                                case 'direct':
                                    $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .visitorreferencearea`).html(`
                                        <div class="visitorReferrer direct">Direct Entry</div>
                                    `);
                                    break;
                                case 'website':
                                    $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .visitorreferencearea`).html(`
                                        <div class="visitorReferrer website">
                                            <span>Website: </span>
                                            <a 
                                                href="${value.referrerUrl}" 
                                                rel="noreferrer noopener" 
                                                target="_blank" 
                                                class="visitorLogTooltip" 
                                                title="${value.referrerUrl}" 
                                                style="text-decoration:underline;">
                                                ${value.referrerName}
                                            </a>
                                        </div>
                                    `);
                                    break;
                                default:
                            }

                            // visit log returning user icon
                            if(value.visitorType == 'returning'){
                                $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails`).append('<span class="visitorLogIconWithDetails visitorTypeIcon"></span>');
                            
                                $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons .visitorDetails span.visitorLogIconWithDetails`).append(`
                                    <img src="${matomoUrl}/${value.visitorTypeIcon}">
                                `);

                                $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons .visitorDetails span.visitorLogIconWithDetails`).append('<ul class="details"></ul>');

                                $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons .visitorDetails span.visitorLogIconWithDetails ul.details`).append(`
                                    <li>Returning Visitor - ${value.visitCount > 1 ? value.visitCount + ' visits': value.visitCount + ' visit'}</li>
                                `);
                            }

                            // visit log flag icon
                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails`)
                            .append(`<span class="visitorLogIconWithDetails flag" profile-header-text=""></span>`);

                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.flag`)
                            .append(`<img src="${matomoUrl}/${value.countryFlag}">`);

                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.flag`)
                            .append(`<ul class="details"></ul>`);

                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.flag ul.details`)
                            .append(`
                                <li>Country: ${value.country}</li>
                                <li>Region: ${value.region}</li>
                                <li>City: ${value.city}</li> 
                                <li>Browser language: ${value.language}</li>  
                                <li>IP: ${value.visitIp}</li>
                                <li>Visitor ID: ${value.visitorId}</li>
                            `);

                            // visit log browser icon
                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails`)
                            .append(`<span class="visitorLogIconWithDetails" profile-header-text="${value.browser}"></span>`);

                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.browser}"]`)
                            .append(`<img src="${matomoUrl}/${value.browserIcon}">`);

                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.browser}"]`)
                            .append(`<ul class="details"></ul>`);

                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.browser}"] ul.details`)
                            .append(`
                                <li>Browser: ${value.browser}</li>
                                <li>Browser engine: ${value.browserFamily}</li>
                                <li id="pluginlist_${index}" class="plugins">
                                    Plugins:
                                </li>
                            `);

                            // visit log operation system icon
                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails`)
                            .append(`<span class="visitorLogIconWithDetails" profile-header-text="${value.operatingSystem}"></span>`);

                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.operatingSystem}"]`)
                            .append(`<img src="${matomoUrl}/${value.operatingSystemIcon}">`);

                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.operatingSystem}"]`)
                            .append(`<ul class="details"></ul>`);

                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.operatingSystem}"] ul.details`)
                            .append(`
                                <li>Operating system: ${value.operatingSystemName} ${value.operatingSystemVersion}</li>
                            `);

                            // visit log resolution icon
                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails`)
                            .append(`<span class="visitorLogIconWithDetails" profile-header-text="${value.resolution}"></span>`);

                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.resolution}"]`)
                            .append(`<img src="${matomoUrl}/${value.deviceTypeIcon}">`);

                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.resolution}"]`)
                            .append(`<ul class="details"></ul>`);

                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.resolution}"] ul.details`)
                            .append(`
                                <li>Device type: ${value.deviceType}</li>
                                <li>Device brand: ${value.deviceBrand}</li>                
                                <li>Device model: ${value.deviceModel}</li>                
                                <li>Resolution: ${value.resolution}</li>  
                            `);


                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .visitorActions`).attr('id', `visitorActions_${index}`);

                            $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .visitorActions`).html(`
                                <strong>${value.actions > 1 ? value.actions + ' Actions' : value.actions + ' Action'}</strong>
                            `);
                            
                            $.each(value.pluginsIcons,function(i,v){
                                $(`#visitorcards .card #pluginlist_${index}`).append(`
                                    <img width="16px" height="16px" src="${matomoUrl}/${v.pluginIcon}" alt="${v.pluginName}">
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
                                $(`#visitorcards .card #visitorActions_${index}`).append(`<div class="visitor-log-page-list"></div>`);
                                $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list`).append('<ol class="visitorLog actionList"></ol>');

                            }

                            $.each(value.actionDetails, function(i,v){
                                if(v.type == 'action'){
                                    $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog`).append(`
                                        <li id="visitor_action_folder_${i}"
                                        class="action folder"
                                        title="${v.serverTimePretty} \n ${v.subtitle} \n ${v.pageLoadTime !== undefined ? `Page load time: ${v.pageLoadTime}` : ''} \n ${v.timeSpentPretty !== undefined ? `Time on page: ${v.timeSpentPretty}` : ''}
                                        "></li>
                                    `);
                                    $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog #visitor_action_folder_${i}`).append(`
                                        <div class="action_folder_inner"><span class="truncated-text-line">${v.title}</span></div>
                                    `);
                                    $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog #visitor_action_folder_${i} .action_folder_inner`).append(`
                                        <img src="${matomoUrl}/${v.iconSVG}" class="action-list-action-icon action">
                                    `);
                                    $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog #visitor_action_folder_${i} .action_folder_inner`).append(`
                                        <p><a href="${v.url}" target="_blank" rel="noreferrer noopener" class="action-list-url truncated-text-line" >${v.url}</a></p>
                                    `);
                                }
                                if(v.type != 'action' && $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog.actionList`).children('.action.folder').length > 0 && $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog .pageviewActions#pageviewActions_${index}`).length > 0){
                                    $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog .pageviewActions#pageviewActions_${index} .actionList`).append(`
                                        <li class="action outlink" title="${v.serverTimePretty} \n ${v.subtitle} \n ${v.timeSpentPretty !== undefined ? `Time on page: ${v.timeSpentPretty}` : ''}">
                                            <div class="outlink_folder_inner">
                                                <img src="${matomoUrl}/${v.iconSVG}" class="action-list-action-icon ${v.type}">
                                                <a href="${v.url}" rel="noreferrer noopener" target="_blank" class="action-list-url truncated-text-line">
                                                    ${v.url}
                                                </a>
                                            </div>
                                        </li>
                                    `);
                                }
                                if(v.type != 'action' && $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog.actionList`).children('.action.folder').length > 0 && $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog .pageviewActions#pageviewActions_${index}`).length == 0){
                                    // add action here from line 691
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
                                                <img src="${matomoUrl}/${v.iconSVG}" class="action-list-action-icon ${v.type}">
                                                <a href="${v.url}" rel="noreferrer noopener" target="_blank" class="action-list-url truncated-text-line">
                                                    ${v.url}
                                                </a>
                                            </div>
                                        </li>
                                    `);
                                }
                                if(v.type != 'action' && $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog.actionList`).children('.action.folder').length == 0) {
                                    $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog.actionList`).append(`
                                        <li class="action" 
                                            title="${v.serverTimePretty}
                                                    ${v.subtitle}
                                                    ${v.timeSpentPretty !== undefined ? `Time on page: ${v.timeSpentPretty}` : ''}">
                                            <div>
                                                <img src="${response.matomoUrl}/${v.iconSVG}" class="action-list-action-icon ${v.type}">
                                                <a href="${v.url}" rel="noreferrer noopener" target="_blank" class="action-list-url truncated-text-line">
                                                    ${v.url}
                                                </a>
                                            </div>
                                        </li>                                         
                                    `)
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
                        $(".pagination-visitors li").slice(1, -1).remove();
                        let arr = getPageList(totalPages, currentPage, paginationSize);
                        arr.forEach(item => {
                            $("<li>", {class : 'page-item ' + (item ? "current-page " : "") + (item === currentPage ? "active " : "")})
                            .append($('<a>', {class : 'page-link', href: "javascript:void(0)" ,text: item || "..."}))
                            .insertBefore(".pagination-visitors #next-page");
                        });
                        return true;
                    }
                    $(".pagination-visitors").append(
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
                    $(document).on("click",".pagination-visitors li.current-page:not(.active)", function(){
                        return showPage(+$(this).text());
                    });
                    $(".pagination-visitors #next-page").on("click", function() {
                        return showPage(currentPage + 1);
                    });
                    $(".pagination-visitors #previous-page").on("click", function() {
                        return showPage(currentPage - 1);
                    });
                    $(".pagination-visitors").on("click", function() {
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
        $(document).on('click','a.visitorLogTooltip',function(){
            let visitorId = $(this).data("visitor-id");
            $.ajax({
                url: "/reportingApi/visitorsummary",
                type: "post",
                data: {
                    visitorid: visitorId,
                },
                success:function(response){
                    $('.modal-visitor-profile-info').attr('id', visitorId);
                    
                    $('<span>', {text: visitorId+" "}).append('.visitor-profile-overview .visitor-profile-header .visitor-profile-id');

                    // visit summary flag 
                    $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').append(`<span class="visitorLogIconWithDetails flag" profile-header-text="${response.visitorProfile.countries[0].cities[0]}"></span>`);
                    $(`.modal-visitor-profile-info .visitorLogIcons .visitorDetails span.visitorLogIconWithDetails.flag[profile-header-text="${response.visitorProfile.countries[0].cities[0]}"]`).append(`
                            <img src="${matomoUrl}/${response.visitorProfile.countries[0].flag}">
                    `);
                    $(`.modal-visitor-profile-info .visitorLogIcons .visitorDetails span.visitorLogIconWithDetails.flag[profile-header-text="${response.visitorProfile.countries[0].cities[0]}"]`).append(`
                            <ul class="details"></ul>
                    `);
                    $(`.modal-visitor-profile-info .visitorLogIcons .visitorDetails span.visitorLogIconWithDetails.flag[profile-header-text="${response.visitorProfile.countries[0].cities[0]}"] ul.details`).append(`
                        <li>Country: ${response.visitorProfile.countries[0].prettyName}</li>
                        <li>City: ${response.visitorProfile.countries[0].cities[0]}</li>                
                        <li>Browser language: ${response.visitorProfile.lastVisits[0].language}</li>                                
                        <li>IP: ${response.visitorProfile.lastVisits[0].visitIp}</li>
                        <li>Visitor ID: ${response.visitorProfile.lastVisits[0].visitorId}</li>
                    `);

                    // visit summary browser
                    $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').append(`
                        <span class="visitorLogIconWithDetails" profile-header-text="${response.visitorProfile.lastVisits[0].browser}"></span>
                    `);

                    $(`.modal-visitor-profile-info .visitorLogIcons .visitorDetails span.visitorLogIconWithDetails[profile-header-text="${response.visitorProfile.lastVisits[0].browser}"]`).append(`
                        <img src="${matomoUrl}/${response.visitorProfile.lastVisits[0].browserIcon}">
                    `);

                    $(`.modal-visitor-profile-info .visitorLogIcons .visitorDetails span.visitorLogIconWithDetails[profile-header-text="${response.visitorProfile.lastVisits[0].browser}"]`).append(`
                        <ul class="details"></ul>
                    `);

                    $(`.modal-visitor-profile-info .visitorLogIcons .visitorDetails span.visitorLogIconWithDetails[profile-header-text="${response.visitorProfile.lastVisits[0].browser}"] ul.details`).append(`
                        <li>Browser: ${response.visitorProfile.lastVisits[0].browser}</li>
                        <li>Browser engine: ${response.visitorProfile.lastVisits[0].browserFamily}</li>
                        <li id="pluginlist_modal${visitorId}" class="plugins">
                            Plugins:
                        </li>
                    `);

                    $.each(response.visitorProfile.lastVisits[0].pluginsIcons,function(i,v){
                        $(`#pluginlist_modal${visitorId}`).append(`
                            <img width="16px" height="16px" src="${matomoUrl}/${v.pluginIcon}" alt="${v.pluginName}">
                        `);
                    });


                    // visit summary operating system
                    $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').append(`
                        <span class="visitorLogIconWithDetails" profile-header-text="${response.visitorProfile.lastVisits[0].operatingSystem}">
                            <img src="${matomoUrl}/${response.visitorProfile.lastVisits[0].operatingSystemIcon}">
                            <ul class="details">
                                <li>Operating system: ${response.visitorProfile.lastVisits[0].operatingSystem}</li>
                            </ul>
                        </span>
                    `);

                    // visit summary resolution
                    $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').append(`
                        <span class="visitorLogIconWithDetails" profile-header-text="${response.visitorProfile.lastVisits[0].resolution}">
                            <img src="${matomoUrl}/${response.visitorProfile.lastVisits[0].deviceTypeIcon}">
                            <ul class="details">
                                <li>Device type: ${response.visitorProfile.lastVisits[0].deviceType}</li>
                                <li>Device brand: ${response.visitorProfile.lastVisits[0].deviceBrand}</li>                
                                <li>Device model: ${response.visitorProfile.lastVisits[0].deviceModel}</li>                
                                <li>Resolution: ${response.visitorProfile.lastVisits[0].resolution}</li>
                            </ul>
                        </span>
                    `);
                    
                    if(response.visitorProfile.totalDownloads > 0){
                        $('.modal-visitor-profile-info .visitor-profile-summary .summary').html(`
                            <p>
                                Spent a total of <strong>${response.visitorProfile.totalVisitDurationPretty}</strong> on the website, and performed 
                                <strong>${response.visitorProfile.totalActions} ${response.visitorProfile.totalActions == 1  ? 'action' : 'actions'}</strong> (${response.visitorProfile.totalPageViews} ${response.visitorProfile.totalPageViews == 1 ? 'Pageview' : 'Pageviews'} ${response.visitorProfile.totalDownloads} ${response.visitorProfile.totalDownloads == 1 ? 'Download' : 'Downloads'}, ${response.visitorProfile.totalOutlinks > 0 ? response.visitorProfile.totalOutlinks == 1 ? response.visitorProfile.totalOutlinks+' Outlink' : response.visitorProfile.totalOutlinks+' Outlinks' : ''} )
                                in ${response.visitorProfile.totalVisits} ${response.visitorProfile.totalVisits == 1  ? 'visit' : 'visits'}.
                                <br>
                                converted ${response.visitorProfile.totalGoalConversions == 1 ? response.visitorProfile.totalGoalConversions+' Goal' : response.visitorProfile.totalGoalConversions+' Goals'}
                                ${ response.visitorProfile.averagePageLoadTime !== undefined ? '<br>Each page took on average'+response.visitorProfile.averagePageLoadTime+'s to load for this visitor.' : ''}
                            </p>
                        `)
                    }else{
                        $('.modal-visitor-profile-info .visitor-profile-summary .summary').html(`
                            <p>
                                Spent a total of <strong>${response.visitorProfile.totalVisitDurationPretty}</strong> on the website, and viewed 
                                ${response.visitorProfile.totalPageViews} ${response.visitorProfile.totalPageViews == 1 ? 'Page' : 'Pages'}
                                in ${response.visitorProfile.totalVisits} ${response.visitorProfile.totalVisits == 1  ? 'visit' : 'visits'}.
                                <br>
                                converted ${response.visitorProfile.totalGoalConversions == 1 ? response.visitorProfile.totalGoalConversions+' Goal' : response.visitorProfile.totalGoalConversions+' Goals'}
                                    ${ response.visitorProfile.averagePageLoadTime !== undefined ? '<br>Each page took on average '+response.visitorProfile.averagePageLoadTime+'s to load for this visitor.' : ''}
                            </p>
                        `)
                    }
                    $('.modal-visitor-profile-info .visitor-profile-summary .ecommerce').html(`
                        <p>
                            Generated a Life Time Revenue of €${response.visitorProfile.totalEcommerceRevenue}. Purchased ${response.visitorProfile.totalEcommerceItems} items in ${response.visitorProfile.totalEcommerceConversions} ecommerce orders.
                        </p>
                    `);
                    $('.modal-visitor-profile-info .visitor-profile-summary .firstlastvisit').html(`
                        <div class="col-6">
                            <h2>First Visit</h2>
                            <div class="firstvisit">
                                <p>
                                    ${response.visitorProfile.firstVisit.prettyDate} <span class="text-muted">- ${response.visitorProfile.firstVisit.daysAgo} days ago</span>
                                    <br>
                                    from <strong>${response.visitorProfile.firstVisit.referralSummary}</strong>
                                </p>
                            </div>
                        </div>
                        <div class="col-6">
                            <h2>Last Visit</h2>
                            <div class="firstvisit">
                                <p>
                                    ${response.visitorProfile.lastVisit.prettyDate} <span class="text-muted">- ${response.visitorProfile.lastVisit.daysAgo} days ago</span>
                                    <br>
                                    from <strong>${response.visitorProfile.firstVisit.referralSummary}</strong>
                                </p>
                            </div>
                        </div>
                    `);
                    $('.modal-visitor-profile-info .visitor-profile-summary .devices').html(``);
                    $(response.visitorProfile.devices).each(function(i, v) {
                        let devices = '';
                        $(v.devices).each(function(index, value){ 
                            devices +=  value.name+"("+value.count+"x)";
                        });
                        $('.modal-visitor-profile-info .visitor-profile-summary .devices').append(`
                            <p>
                                <img height="16" src="${matomoUrl}/${v.icon}">
                                <span>
                                    <strong>${v.count}</strong> visits from <strong>${v.type}</strong>
                                    devices: ${devices} 
                                </span>
                            </p>
                        `);
                    });
                    $('.modal-visitor-profile-info .visitor-profile-summary .location').html(``);
                    $(response.visitorProfile.countries).each(function(i,v){
                        let cities = '';
                        if($(v.cities).length > 1)
                        {    
                            $(v.cities).each(function(index, value){ 
                                cities +=  value+","
                            });
                        }else{
                            $(v.cities).each(function(index, value){ 
                                cities +=  value
                            });
                        }
                        $('.modal-visitor-profile-info .visitor-profile-summary .location').append(`
                            <p>
                                <strong>${v.nb_visits == 1 ? v.nb_visits+" visit": v.nb_visits+" visits"}</strong> 
                                from 
                                <span title="${cities}">different cities</span>, ${v.prettyName}&nbsp;
                                <img height="16px" src="${matomoUrl}/${v.flag}" title="${v.prettyName}">        
                                <a class="visitor-profile-show-map" href="#">(show&nbsp;map)</a> 
                            </p>
                        `);
                    })
                    $('.modal-visitor-profile-info .visitor-profile-visits-info').html(``);
                    $(response.visitorProfile.lastVisits).each(function(i,v){
                        $(`.modal-visitor-profile-info .visitor-profile-visits-info`).append(`
                            <div class="visitor-profile-visit-title row">
                                Visit #<span class="counter">${response.visitorProfile.lastVisits.length - i}</span>
                                <span class="visitor-profile-date" title="${v.serverDatePrettyFirstAction} ${v.serverTimePrettyFirstAction}">
                                    ${v.serverDatePrettyFirstAction} ${v.serverTimePrettyFirstAction}
                                </span>
                            </div>
                        `);
                        
                        $('.modal-visitor-profile-info .visitor-profile-visits-info').append(`
                            <div class="visitor-profile-visit-details" id=${'visit'+(response.visitorProfile.lastVisits.length - i)}>
                                <span class="visitorDetails">
                                    <span class="visitorLogIconWithDetails" profile-header-text="${v.browser}">
                                        <img src="${matomoUrl}/${v.browserIcon}">
                                        <ul class="details">
                                            <li>Browser: ${v.browser}</li>
                                            <li>Browser engine: ${v.browserFamily}</li>
                                            <li id="pluginlist_modal${visitorId}_${i}" class="plugins">
                                                Plugins:
                                            </li>
                                        </ul>
                                    </span>
                                    <span class="visitorLogIconWithDetails" profile-header-text="${v.operatingSystem}">
                                        <img src="${matomoUrl}/${v.operatingSystemIcon}">
                                        <ul class="details">
                                            <li>Operating system: ${v.operatingSystem}</li>
                                        </ul>
                                    </span>
                                    <span class="visitorLogIconWithDetails" profile-header-text="${v.resolution}">
                                        <img src="${matomoUrl}/${v.deviceTypeIcon}">
                                        <ul class="details">
                                            <li>Device type: ${v.deviceType}</li>
                                            <li>Device brand: ${v.deviceBrand}</li>                
                                            <li>Device model: ${v.deviceModel}</li>                
                                            <li>Resolution: ${v.resolution}</li>            
                                        </ul>
                                    </span>
                                </span>
                                <a href="#" class="visitor-profile-show-actions ml-auto">
                                    ${v.actions} ${v.actions == 1 ? 'action' : 'actions'} in ${v.visitDurationPretty}
                                </a>
                            </div>
                        `);
                        $.each(v.pluginsIcons,function(index,value){
                            $(`.modal-visitor-profile-info .visitor-profile-visit-details#${'visit'+(response.visitorProfile.lastVisits.length - i)} .visitorDetails .visitorLogIconWithDetails #pluginlist_modal${visitorId}_${i}`).append(`
                                <img width="16px" height="16px" src="${matomoUrl}/${value.pluginIcon}" alt="${value.pluginName}">
                            `);
                        });
                        if(v.sessionReplayUrl !== null){
                            $(`.modal-visitor-profile-info .visitor-profile-visit-details#${'visit'+(response.visitorProfile.lastVisits.length - i)}`).prepend(`
                                <a 
                                    class="visitorLogReplaySession" 
                                    href="${matomoUrl}/index.php${v.sessionReplayUrl}" 
                                    target="_blank" rel="noreferrer noopener"><i class="far fa-play-circle"></i>
                                </a>
                            `);
                            $(`.modal-visitor-profile-info .visitor-profile-visit-details#${'visit'+(response.visitorProfile.lastVisits.length - i)} .visitorDetails`).css("margin-left", "26px")
                        } 
                        
                            
                        $(`.modal-visitor-profile-info .visitor-profile-visit-details#${'visit'+(response.visitorProfile.lastVisits.length - i)}`).append(`
                            <ol class="visitorLog visitor-profile-actions actionList"></ol>
                        `);
                        $(v.actionDetails).each(function(index, value){
                            switch(value.type){
                                case 'action':
                                $(`.modal-visitor-profile-info .visitor-profile-visit-details#${'visit'+(response.visitorProfile.lastVisits.length - i)} .actionList`).append(`
                                        <li class="action folder" 
                                            title="
                                            ${value.serverTimePretty}
                                            ${value.subtitle}
                                            ${value.pageLoadTime !== undefined ? `Page load time: ${value.pageLoadTime}` : ''}
                                            ${value.timeSpentPretty !== undefined ? `Time on page: ${value.timeSpentPretty}` : ''}
                                        ">
                                            <div>
                                                <span class="truncated-text-line">${value.title}</span>
                                                <img src="${matomoUrl}/${value.iconSVG}" class="action-list-action-icon action">
                                                <p>                  
                                                    <a 
                                                        href="${value.url}" 
                                                        rel="noreferrer noopener" 
                                                        target="_blank" 
                                                        class="action-list-url truncated-text-line">
                                                            ${value.url}
                                                    </a>
                                                </p>            
                                            </div>
                                        </li>
                                    `);
                                    break;
                                case 'outlink':
                                    $(`.modal-visitor-profile-info .visitor-profile-visit-details#${'visit'+(response.visitorProfile.lastVisits.length - i)} .actionList`).append(`
                                        <li class="action outlink ml-3" 
                                            title="
                                            ${value.serverTimePretty}
                                            ${value.subtitle}
                                            ${value.pageLoadTime !== undefined ? `Page load time: ${value.pageLoadTime}` : ''}
                                            ${value.timeSpentPretty !== undefined ? `Time on page: ${value.timeSpentPretty}` : ''}
                                        ">
                                            <div>
                                                <span class="truncated-text-line">${value.title}</span>
                                                <img src="${matomoUrl}/${value.iconSVG}" class="action-list-action-icon action">
                                                <p>                  
                                                    <a 
                                                        href="${value.url}" 
                                                        rel="noreferrer noopener" 
                                                        target="_blank" 
                                                        class="action-list-url truncated-text-line">
                                                            ${value.url}
                                                    </a>
                                                </p>            
                                            </div>
                                        </li>
                                    `);
                                    break;
                                case 'download':
                                    $(`.modal-visitor-profile-info .visitor-profile-visit-details#${'visit'+(response.visitorProfile.lastVisits.length - i)} .actionList`).append(`
                                        <li class="action download ml-3" 
                                            title="
                                            ${value.serverTimePretty}
                                            ${value.subtitle}
                                            ${value.pageLoadTime !== undefined ? `Page load time: ${value.pageLoadTime}` : ''}
                                            ${value.timeSpentPretty !== undefined ? `Time on page: ${value.timeSpentPretty}` : ''}
                                        ">
                                            <div>
                                                <span class="truncated-text-line">${value.title}</span>
                                                <img src="${matomoUrl}/${value.iconSVG}" class="action-list-action-icon action">
                                                <p>                  
                                                    <a 
                                                        href="${value.url}" 
                                                        rel="noreferrer noopener" 
                                                        target="_blank" 
                                                        class="action-list-url truncated-text-line">
                                                            ${value.url}
                                                    </a>
                                                </p>            
                                            </div>
                                        </li>
                                    `);
                                    break;
                                default:
                            }
                        });
                    });

                    $(`#${visitorId}`).modal({
                        show: true
                    });
                    
                }
            });
        });
        $('.modal-visitor-profile-info').on('hidden.bs.modal', function(){
             $('.modal-visitor-profile-info').removeAttr('id');
             $('.modal-visitor-profile-info .modal-body .visitor-profile-overview .visitor-profile-header .visitor-profile-id span:last-of-type').remove();
             $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').empty();
        });
    });
    
    $(document).ajaxStop(function () {
        $('.menu-items-content div.matomo-items.active').show();
        $('.menu-items-content .loader').hide();
    });
</script>