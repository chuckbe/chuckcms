<script>
    let _token = $('meta[name="csrf-token"]').attr('content');
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
    //  heatmaps
    
    function getHeatMaps(){
        $.ajax({
            url: "/dashboard/matomo/api/heatmaps",
            type: "post",
            data: {
                _token: _token
            },
            success:function(response){
                if(response.success == 'success'){
                    $(`div[data-item="heatmap"] #Heatmapcards`).empty();
                    $(`nav#sidebarMenu .nav .nav-item [data-category="heatmaps"]`).parent().find(`.sidebar-sub-menu`).empty();
                    $(response.heatMaps).each(function(i, v) {
                        $(`nav#sidebarMenu .nav .nav-item [data-category="heatmaps"]`).parent().find(`.sidebar-sub-menu`).append(`
                            <li ${i == 0  ? 'class="active"' : ''}>
                                <a class="text-dark" data-link="heatmap" data-heatmapname="${(v.name).replace(/\s+/g, '-').toLowerCase()}" target="_blank" href="${response.matomoUrl}/${v.heatmapViewUrl}">${v.name}</a>
                            </li>
                        `)
                        $(`div[data-item="heatmap"] #Heatmapcards`).append(`
                            <li class="heatmapcard${i == 0 ? ' active' : ''}" data-heatmap=${(v.name).replace(/\s+/g, '-').toLowerCase()}>
                                <iframe style="height: 5000px" class="w-100 border-0" id="iframe_${(v.name).replace(/\s+/g, '-').toLowerCase()}" src="${response.matomoUrl}/${v.heatmapViewUrl}"></iframe>
                            </li>
                        `);
                    });
                    if(!$(`nav#sidebarMenu .nav .nav-item [data-category="heatmaps"]`).parent().hasClass( "active" )){
                        $(`nav#sidebarMenu .nav .nav-item [data-category="heatmaps"]`).parent().find(`.sidebar-sub-menu li`).each(function(index, el){
                            if($(el).hasClass( "active" )){
                                $(el).removeClass("active");
                            }
                        });
                        if($(`nav#sidebarMenu .nav .nav-item [data-category="heatmaps"]`).hasClass( "active")){
                            $(`nav#sidebarMenu .nav .nav-item [data-category="heatmaps"]`).removeClass("active");
                        }
                    }
                }
            },
            complete: function(){

            }
        });
    }

    function liveCounter(){
        $.ajax({
            url: "/dashboard/matomo/api/livecounter",
            type: "post",
            data: {
                _token: _token
            },
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
                value : convertedRange,
                _token: _token
            },
            success:function(response){
                if(response.success == 'success'){
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
            },
            complete: function(){
                // forceView=1&viewDataTable=sparkline&module=API&action=get&idSite=10&period=day&date=2021-07-19,2021-08-17&segment=&showtitle=1&random=6179&columns=nb_visits%2Cnb_uniq_visitors&colors=%7B"backgroundColor"%3A"%23ffffff"%2C"lineColor"%3A"%23162c4a"%2C"minPointColor"%3A"%23ff7f7f"%2C"maxPointColor"%3A"%2375bf7c"%2C"lastPointColor"%3A"%2355aaff"%2C"fillColor"%3A"%23ffffff"%7D
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
                value : convertedRange,
                _token: _token
            },
            success:function(response){
                if(response.success == 'success'){
                    console.log(response.data);
                    $('#referrers .referrerslist').empty();
                    $.each(response.data ,  function(k, v){
                        $('#referrers .referrerslist').append(`<li class="py-2">
                            <div>
                                <img src="${response.matomoUrl}/${v.logo}" style="max-width: 15px">
                                <span>${v.label} :</span>
                                <span>${v.nb_uniq_visitors}</span>
                            </div>
                            
                        </li>`)
                    })
                    
                }
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
    function getSessionRecordings(){
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
            url: "/dashboard/matomo/api/sessionrecordings",
            type: "post",
            data: {
                value : convertedRange,
                _token: _token
            },
            success:function(response){
                if(response.success == 'success'){
                    
                    $('#sessionrecordings .tbody').empty()
                    $(response.recordedSessions).each(function(index, el){
                        let seconds = Math.floor(el.time_on_site/1000);
                        let d = Math.floor(seconds / (3600*24));
                        let h = Math.floor(seconds % (3600*24) / 3600);
                        let m = Math.floor(seconds % 3600 / 60);
                        let s = Math.floor(seconds % 60);

                        $('#sessionrecordings tbody').append(`
                            <tr data-sitehr=${response.sitehrs} data-expanded="${el.first_url == el.last_url ? 'false' : 'true'}" data-loghr=${el.idloghsr}>
                                <td class="position-relative" title="${el.first_url == el.last_url ? el.first_url : el.first_url+'→'+el.last_url}" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;max-width: 30ch;">
                                    ${el.first_url == el.last_url ? '<span class="icon-outlink"></span> '+el.first_url : '<span class="icon-btn"></span> '+el.first_url+"→"+el.last_url}
                                    <div class="play-icons position-absolute">
                                        <a class="session-play" href="${response.matomoUrl}/${el.sessionReplayUrl}" target="_blank"><i class="far fa-play-circle" aria-hidden="true"></i></a>
                                        <a class="session-visitor visitorLogTooltip" data-visitor-id="${el.idvisitor}">
                                            <i class="fa fa-id-card" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                </td>
                                <td>${el.nb_pageviews}</td>
                                <td>${moment(el.server_time).format('MMM Do YYYY hh:mm:ss')}</td>
                                <td>
                                ${d > 0 ? (d > 9 ? d+":" : "0"+d+":") : ""}
                                ${h > 0 ? (h > 9 ? h+":" : "0"+h+":") : ""}
                                ${m > 0 ? (m > 9 ? m+":" : "0"+m+":") : "00:"}
                                ${s > 0 ? (s > 9 ? s : "0"+s) : "00"}
                                </td>
                                <td title="${el.location_city}">
                                    <img 
                                        width="16" 
                                        class="flag" 
                                        src="${response.matomoUrl}/plugins/Morpheus/icons/dist/flags/${el.location_country}.png">
                                </td>
                                <td title="${el.config_device_model}">
                                    <img 
                                        width="16" 
                                        src="${response.matomoUrl}/plugins/Morpheus/icons/dist/devices/${el.config_device_type == 0 ? 'desktop' : el.config_device_type == 1 ? 'smartphone' : 'tablet'}.png">
                                </td>
                                <td title="${el.config_os}"><img width="16" src="${response.matomoUrl}/plugins/Morpheus/icons/dist/os/${el.config_os}.png"></td>
                                <td title="${el.config_browser_name}"><img width="16" src="${response.matomoUrl}/plugins/Morpheus/icons/dist/browsers/${el.config_browser_name}.png"></td>
                            </tr>
                        `);
                    })
                }
            },
            complete: function(){
                $('table#sessionrecordings').footable({
                    "paging": {
                        "size": 10,
                        "enabled": true
                    },
                    calculateWidthOverride: function() {
                        return { width: $(window).width() };
                    }
                });
                $(document).on('click', '#sessionrecordings tbody tr', function(){
                    let row = $(this);
                    if($(this).data('expanded')){
                        $('#sessionrecordings tbody tr').not(this).each(function(index, el){
                            $(el).find('.icon-btn.expanded').removeClass('expanded')
                        });
                        if($(this).find('.icon-btn').hasClass('expanded')){
                            $(this).find('.icon-btn').removeClass('expanded')
                        }else{
                            $(this).find('.icon-btn').addClass('expanded')
                            $.ajax({
                                url: "/dashboard/matomo/api/recordedsessions",
                                type: "post",
                                data: {
                                    idLogHsr: $(this).data('loghr'),
                                    idSiteHsr: $(this).data('sitehr'),
                                    _token: _token
                                },
                                success:function(response){
                                    if(response.success == 'success'){
                                        $(row).append(`
                                            <tr>
                                                <table id="${$(this).data('sitehr')}" data-paging="true" class="table table-bordered table-hover footable">
                                                    <thead>
                                                        <tr>
                                                            <th>URL</th>
                                                            <th>TIME</th>
                                                            <th>TIME ON PAGE</th>
                                                            <th>RESOLUTION</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </tr>
                                        `)

                                        console.log(response.recordedSession)
                                    }
                                },
                                complete: function(){

                                }
                            });
                        }
                    }
                });
            }
        });
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
                case 'heatmaps':
                    $('.menu-items-content .matomo-items').each(function(index, el){
                        if($(el).hasClass( "active" )){
                            $(el).removeClass("active");
                        }
                    });
                    $(`.menu-items-content div[data-item='heatmap']`).addClass("active");
                    getHeatMaps();
                    $(`#sidebarMenu .nav-item.active .sidebar-sub-menu li:first`).addClass("active");
                    $(`.menu-items-content div[data-item='heatmap'] #Heatmapcards li:first`).addClass("active");
                    break;
                case 'sessionrecordings':
                    $('.menu-items-content .matomo-items').each(function(index, el){
                        if($(el).hasClass( "active" )){
                            $(el).removeClass("active");
                        }
                    });
                    $(`.menu-items-content div[data-item='sessionrecordings']`).addClass("active");
                    getSessionRecordings();
                    break;
                default:
            }
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
                    _token: _token
                },
                success:function(response){
                    if(response.success == 'success'){
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
                                                        <img width="16" class="flag" src="${response.matomoUrl}/${value.countryFlag}">&nbsp;
                                                        ${value.city}
                                                    </span>
                                                </span>
                                                ${value.referrerType == 'search' ? `<div class="visitorReferrer search"><span title="${value.referrerKeyword}"><img class="mr-2" width="16" src="${response.matomoUrl}/${value.referrerSearchEngineIcon}" alt="${value.referrerName}"><span>${value.referrerName}</span></span></div>` : ''}
                                                ${value.referrerType == 'direct' ? `<div class="visitorReferrer direct">Direct Entry</div>` : ''}
                                                ${value.referrerType == 'website' ? `<div class="visitorReferrer website"><span>Website: </span><a href="${value.referrerUrl}" rel="noreferrer noopener" target="_blank" class="visitorLogTooltip" title="${value.referrerUrl}" style="text-decoration:underline;">${value.referrerName}</a></div>` : ''}
                                                ${value.sessionReplayUrl !== null ? `<a class="visitorLogReplaySession" href="${response.matomoUrl}/index.php${value.sessionReplayUrl}" target="_blank" rel="noreferrer noopener"><i class="far fa-play-circle"></i> Replay recorded session</a>` : ''}
                                            </div> 
                                            <div class="col s12 m2 own-visitor-column"> 
                                                <span class="visitorLogIcons">
                                                    <span class="visitorDetails">
                                                        ${value.visitorType == 'returning' ? `<span class="visitorLogIconWithDetails visitorTypeIcon"><img src="${response.matomoUrl}/${value.visitorTypeIcon}"><ul class="details"><li>Returning Visitor - ${value.visitCount > 1 ? value.visitCount + ' visits': value.visitCount + ' visit'}</li></ul></span>` : ``}
                                                        <span class="visitorLogIconWithDetails flag" profile-header-text="Warrenville">
                                                            <img src="${response.matomoUrl}/${value.countryFlag}">
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
                                                            <img src="${response.matomoUrl}/${value.browserIcon}">
                                                            <ul class="details">
                                                                <li>Browser: ${value.browser}</li>
                                                                <li>Browser engine: ${value.browserFamily}</li>
                                                                <li id="pluginlist_${index}" class="plugins">
                                                                    Plugins:
                                                                </li>
                                                            </ul>
                                                        </span>
                                                        <span class="visitorLogIconWithDetails" profile-header-text="${value.operatingSystem}">
                                                            <img src="${response.matomoUrl}/${value.operatingSystemIcon}">
                                                            <ul class="details">
                                                                <li>Operating system: ${value.operatingSystemName} ${value.operatingSystemVersion}</li>
                                                            </ul>
                                                        </span>
                                                        <span class="visitorLogIconWithDetails" profile-header-text="${value.resolution}">
                                                            <img src="${response.matomoUrl}/${value.deviceTypeIcon}">
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
                                        <img width="16px" height="16px" src="${response.matomoUrl}/${v.pluginIcon}" alt="${v.pluginName}">
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
                                                    <img src="${response.matomoUrl}/${v.iconSVG}" class="action-list-action-icon action">
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
                                                            <img src="${response.matomoUrl}/${v.iconSVG}" class="action-list-action-icon ${v.type}">
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
                                                            <img src="${response.matomoUrl}/${v.iconSVG}" class="action-list-action-icon ${v.type}">
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
                                                        <img src="${response.matomoUrl}/${v.iconSVG}" class="action-list-action-icon ${v.type}">
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
            getHeatMaps();
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
                    _token: _token
                },
                success:function(response){
                    if(response.success == 'success'){
                        $('.modal-visitor-profile-info').attr('id', visitorId);
                        $('<span>', {text: visitorId+" "}).append('.visitor-profile-overview .visitor-profile-header .visitor-profile-id');
                        $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').append(`
                            <span class="visitorLogIconWithDetails flag" profile-header-text="${response.visitorProfile.countries[0].cities[0]}">
                                <img src="${response.matomoUrl}/${response.visitorProfile.countries[0].flag}">
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
                                <img src="${response.matomoUrl}/${response.visitorProfile.lastVisits[0].browserIcon}">
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
                                <img width="16px" height="16px" src="${response.matomoUrl}/${v.pluginIcon}" alt="${v.pluginName}">
                            `);
                        });
                        $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').append(`
                            <span class="visitorLogIconWithDetails" profile-header-text="${response.visitorProfile.lastVisits[0].operatingSystem}">
                                <img src="${response.matomoUrl}/${response.visitorProfile.lastVisits[0].operatingSystemIcon}">
                                <ul class="details">
                                    <li>Operating system: ${response.visitorProfile.lastVisits[0].operatingSystem}</li>
                                </ul>
                            </span>
                        `);
                        $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').append(`
                            <span class="visitorLogIconWithDetails" profile-header-text="${response.visitorProfile.lastVisits[0].resolution}">
                                <img src="${response.matomoUrl}/${response.visitorProfile.lastVisits[0].deviceTypeIcon}">
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
                                    <img height="16" src="${response.matomoUrl}/${v.icon}">
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
                                    <img height="16px" src="${response.matomoUrl}/${v.flag}" title="${v.prettyName}">        
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
                                            <img src="${response.matomoUrl}/${v.browserIcon}">
                                            <ul class="details">
                                                <li>Browser: ${v.browser}</li>
                                                <li>Browser engine: ${v.browserFamily}</li>
                                                <li id="pluginlist_modal${visitorId}_${i}" class="plugins">
                                                    Plugins:
                                                </li>
                                            </ul>
                                        </span>
                                        <span class="visitorLogIconWithDetails" profile-header-text="${v.operatingSystem}">
                                            <img src="${response.matomoUrl}/${v.operatingSystemIcon}">
                                            <ul class="details">
                                                <li>Operating system: ${v.operatingSystem}</li>
                                            </ul>
                                        </span>
                                        <span class="visitorLogIconWithDetails" profile-header-text="${v.resolution}">
                                            <img src="${response.matomoUrl}/${v.deviceTypeIcon}">
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
                                    <img width="16px" height="16px" src="${response.matomoUrl}/${value.pluginIcon}" alt="${value.pluginName}">
                                `);
                            });
                            if(v.sessionReplayUrl !== null){
                                $(`.modal-visitor-profile-info .visitor-profile-visit-details#${'visit'+(response.visitorProfile.lastVisits.length - i)}`).prepend(`
                                    <a 
                                        class="visitorLogReplaySession" 
                                        href="${response.matomoUrl}/index.php${v.sessionReplayUrl}" 
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
                                                    <img src="${response.matomoUrl}/${value.iconSVG}" class="action-list-action-icon action">
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
                                                    <img src="${response.matomoUrl}/${value.iconSVG}" class="action-list-action-icon action">
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
                                                    <img src="${response.matomoUrl}/${value.iconSVG}" class="action-list-action-icon action">
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
                }
            });
        });
        $('.modal-visitor-profile-info').on('hidden.bs.modal', function(){
             $('.modal-visitor-profile-info').removeAttr('id');
             $('.modal-visitor-profile-info .modal-body .visitor-profile-overview .visitor-profile-header .visitor-profile-id span:last-of-type').remove();
             $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails').empty();
        });
    });
</script>