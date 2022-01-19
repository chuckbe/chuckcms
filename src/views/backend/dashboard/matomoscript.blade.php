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
                    let response_log_length = response.lastVisitsDetails.length;
                    $('#visitoroverviewcards #visitoroverview').empty();
                    $('#visitorcards').empty();

                    if(response_log_length == 0) {
                        $('#visitorcards').html('<h2>Data not available</h2>');
                        $("#visitorcards ").siblings('nav').remove();
                    }
                    if(response_log_length > 0){
                        $('.matomo-items ul#visitorcards').html(response.htmlData);
                    }
                    let logBlock = $('.matomo-items ul#visitorcards > li.card');
                    $.each(response.lastVisitsDetails, function( index, value ) {
                        let tts = 0;
                        let flag = matomoUrl+'/'+value.countryFlag;
                        let countryFlagIcon = $('<img>').attr({
                            width: '16px',
                            class: 'flag',
                            src: flag
                        });
                        $.each(value.actionDetails,function(i,v){
                            if("timeSpent" in v) tts = parseInt(v.timeSpent, 10) + tts;
                        });
                        $(logBlock).clone().appendTo('.matomo-items ul#visitorcards');
                        let getLastLogBlock = $('.matomo-items ul#visitorcards').children('li.card').last();
                        $(getLastLogBlock).attr('data-log', `${index}_${value.visitorId}`);
                        let thisLogBlog = $(`#visitorcards li.card[data-log=${index}_${value.visitorId}]`);
                        $(thisLogBlog).removeClass('d-none');
                        $(thisLogBlog).find(`a.visitor-log-visitor-profile-link`).attr('data-visitor-id', value.visitorId);
                        $(thisLogBlog).find(`strong.visitorLogTooltip`).attr('title', `This visitor's last visit was ${parseInt(((value.secondsSinceLastVisit/60)/60)/24,10)} days ago.`);
                        $(thisLogBlog).find(`strong.visitorLogTooltip`).text(`${value.serverDatePretty} - ${value.serverTimePretty}`);
                        $(thisLogBlog).find(`span.visitor-log-ip-location`).attr('title', `Visitor ID: ${value.visitorId} \n Visit ID: ${value.idVisit} \n ${value.location} \n GPS (lat/long): ${value.latitude},${value.longitude}`);
                        $(thisLogBlog).find(`span.visitor-log-ip-location #visitip`).css({'font-size': "11px"});
                        $(thisLogBlog).find('span.visitor-log-ip-location span#visitor_city_span').html('&nbsp;'+value.city);
                        $(thisLogBlog).find('span.visitor-log-ip-location span#visitor_city_span').prepend(countryFlagIcon);

                        switch(value.referrerType) {
                            case 'search':
                                let referrerSearchEngineIcon = matomoUrl+'/'+value.referrerSearchEngineIcon
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.direct').remove();
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.website').remove();
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.search').removeClass('d-none')
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.search span.referrerKeyword').attr('title', value.referrerKeyword);
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.search span.referrerKeyword img').attr('alt', value.referrerName);
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.search span.referrerKeyword img').attr('src', referrerSearchEngineIcon);
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.search span.referrerKeyword span').text(value.referrerName);
                                break;
                            case 'direct':
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.search').remove();
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.website').remove();
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.direct').removeClass('d-none');
                                break;
                            case 'website':
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.direct').remove();
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.search').remove();
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.website').removeClass('d-none');
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.website a.visitorLogTooltip').attr('title', value.referrerUrl);
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.website a.visitorLogTooltip').attr('href', value.referrerUrl);
                                $(thisLogBlog).find('.visitorreferencearea .visitorReferrer.website a.visitorLogTooltip').text(value.referrerUrl);
                                break;
                            default:
                        }

                        // visit log returning user icon
                        let returningVisitorIcon = matomoUrl+'/'+value.visitorTypeIcon
                        $(thisLogBlog).find('.own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.visitorTypeIcon img').attr('src', returningVisitorIcon);
                        if(value.visitorType == 'returning'){
                            $(thisLogBlog).find('.own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.visitorTypeIcon').removeClass('d-none');
                        }
                        $(thisLogBlog).find('.own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.visitorTypeIcon ul.details li').html(`
                            Returning Visitor - ${value.visitCount > 1 ? value.visitCount + ' visits': value.visitCount + ' visit'}
                        `);

                         // visit log flag icon
                         let countryFlagIconLink = matomoUrl+'/'+value.countryFlag;
                         $(thisLogBlog).find('.own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.flag img').attr('src', countryFlagIconLink);

                         $(thisLogBlog).find('.own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.flag ul.details').html(`
                            <li>Country: ${value.country}</li>
                            <li>Region: ${value.region}</li>
                            <li>City: ${value.city}</li> 
                            <li>Browser language: ${value.language}</li>  
                            <li>IP: ${value.visitIp}</li>
                            <li>Visitor ID: ${value.visitorId}</li>
                         `);

                         // visit log browser icon
                         let browserImageIcon = matomoUrl+'/'+value.browserIcon;
                         $(thisLogBlog).find('.own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.browser').attr('profile-header-text', value.browser);
                         $(thisLogBlog).find('.own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.browser img').attr('src', browserImageIcon);
                         $(thisLogBlog).find('.own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.browser ul.details').html(`
                            <li>Browser: ${value.browser}</li>
                            <li>Browser engine: ${value.browserFamily}</li>
                            <li id="pluginlist_${index}" class="plugins">Plugins:</li>
                         `);

                        //  visit log operating system
                        let operatingSystemIcon = matomoUrl+'/'+value.operatingSystemIcon;
                         $(thisLogBlog).find('.own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.operatingsystem').attr('profile-header-text', value.operatingSystem);
                         $(thisLogBlog).find('.own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.operatingsystem img').attr('src', operatingSystemIcon);
                         $(thisLogBlog).find('.own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.operatingsystem ul.details').html(`
                            <li>Operating system: ${value.operatingSystemName} ${value.operatingSystemVersion}</li>
                         `);

                         //  visit log resolution
                        let deviceTypeIcon = matomoUrl+'/'+value.deviceTypeIcon;
                         $(thisLogBlog).find('.own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.resolution').attr('profile-header-text', value.resolution);
                         $(thisLogBlog).find('.own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.resolution img').attr('src', deviceTypeIcon);
                         $(thisLogBlog).find('.own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.resolution ul.details').html(`
                            <li>Device type: ${value.deviceType}</li>
                            <li>Device brand: ${value.deviceBrand}</li>                
                            <li>Device model: ${value.deviceModel}</li>                
                            <li>Resolution: ${value.resolution}</li>  
                         `); 
                        let noOfActionsText =  value.actions > 1 ? value.actions + ' Actions' : value.actions + ' Action';
                        let actionTimmingText = '';
                        let min = Math.floor(tts / 60);
                        let sec = tts - (Math.floor(tts / 60) * 60);
                        actionTimmingText = min <= 0 ? ` - ${sec}s` : (sec > 0 ? ` - ${min} min ${sec}s` : ` - ${min} min`);
                        $(thisLogBlog).find('.visitorActions > strong').text(noOfActionsText+actionTimmingText);
                        if(value.actions > 0){
                            $(thisLogBlog).find('.visitor-log-page-list .visitorLog.actionList').removeClass('d-none');
                        }
                        let actionListblock = $(thisLogBlog).find('.visitor-log-page-list .visitorLog.actionList li.action');
                        $.each(value.actionDetails, function(i,v){
                            $(actionListblock).clone().appendTo($(thisLogBlog).find('.visitor-log-page-list .visitorLog.actionList'));
                            let getLastLogAction = $(thisLogBlog).find('.visitor-log-page-list .visitorLog.actionList').children('li.action').last();
                            $(getLastLogAction).attr('id', `logaction_${index}`);
                            let thisLogAction = $(thisLogBlog).find(`.visitor-log-page-list .visitorLog.actionList li.action#logaction_${index}`);
                            $(thisLogAction).removeClass('d-none');
                            $(thisLogAction).attr('title', `${v.serverTimePretty} \n ${v.subtitle} \n ${v.pageLoadTime !== undefined ? `Page load time: ${v.pageLoadTime}` : ''} \n ${v.timeSpentPretty !== undefined ? `Time on page: ${v.timeSpentPretty}` : ''}`);
                            switch(v.type){
                                case 'action':
                                    $(thisLogAction).addClass('folder');
                                    $(thisLogAction).find('.action_inner .truncated-text-line').text(v.title);
                                    $(thisLogAction).find('.action_inner img').text(v.title);
                                    break;
                                default:
                            }
                        });

                         
                    });
                    
                    // $('#visitoroverviewcards #visitoroverview').empty();
                    // $('#visitorcards').empty();
                    // $('#visitorcards').html('<h2>Data not available</h2>');
                    

                    // if(response.lastVisitsDetails.length > 0){
                    //     $.each(response.lastVisitsDetails, function( index, value ) {
                    //         let tts = 0;
                    //         $.each(value.actionDetails,function(i,v){
                    //             if("timeSpent" in v){
                    //                 tts = parseInt(v.timeSpent, 10) + tts;
                    //             }
                    //         });

                    //         $("#visitorcards").append(`<li class="card shadow my-3" data-log="${index}_${value.visitorId}">${response.htmlData}</li>`);
                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] a.visitor-log-visitor-profile-link`).attr('data-visitor-id', value.visitorId);
                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] strong.visitorLogTooltip`)
                    //         .attr('title', `This visitor's last visit was ${parseInt(((value.secondsSinceLastVisit/60)/60)/24,10)} days ago.`);
                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] strong.visitorLogTooltip`).text(`
                    //             ${value.serverDatePretty}
                    //             - ${value.serverTimePretty}
                    //         `);

                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] span.visitor-log-ip-location`)
                    //         .attr('title', `Visitor ID: ${value.visitorId} \n Visit ID: ${value.idVisit} \n ${value.location} \n GPS (lat/long): ${value.latitude},${value.longitude}
                    //         `);
                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] span.visitor-log-ip-location #visitip`).text(`
                    //             IP: ${value.visitIp}
                    //         `);
                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] span.visitor-log-ip-location #visitip`).css({
                    //             'font-size': "11px"
                    //         });
                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] span.visitor-log-ip-location span#visitor_city_span`).html(`
                    //             <img width="16" class="flag" src="${matomoUrl}/${value.countryFlag}"> &nbsp;
                    //             ${value.city}
                    //         `);

                    //         switch(value.referrerType) {
                    //             case 'search':
                    //                 $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .visitorreferencearea`).html(`
                    //                     <div class="visitorReferrer search">
                    //                         <span title="${value.referrerKeyword}">
                    //                             <img 
                    //                                 class="mr-2" 
                    //                                 width="16" 
                    //                                 src="${matomoUrl}/${value.referrerSearchEngineIcon}" 
                    //                                 alt="${value.referrerName}">
                    //                             <span>${value.referrerName}</span>
                    //                         </span>
                    //                     </div>
                    //                 `);
                    //                 break;
                    //             case 'direct':
                    //                 $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .visitorreferencearea`).html(`
                    //                     <div class="visitorReferrer direct">Direct Entry</div>
                    //                 `);
                    //                 break;
                    //             case 'website':
                    //                 $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .visitorreferencearea`).html(`
                    //                     <div class="visitorReferrer website">
                    //                         <span>Website: </span>
                    //                         <a 
                    //                             href="${value.referrerUrl}" 
                    //                             rel="noreferrer noopener" 
                    //                             target="_blank" 
                    //                             class="visitorLogTooltip" 
                    //                             title="${value.referrerUrl}" 
                    //                             style="text-decoration:underline;">
                    //                             ${value.referrerName}
                    //                         </a>
                    //                     </div>
                    //                 `);
                    //                 break;
                    //             default:
                    //         }

                    //         // visit log returning user icon
                    //         if(value.visitorType == 'returning'){
                    //             $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails`).append('<span class="visitorLogIconWithDetails visitorTypeIcon"></span>');
                            
                    //             $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons .visitorDetails span.visitorLogIconWithDetails`).append(`
                    //                 <img src="${matomoUrl}/${value.visitorTypeIcon}">
                    //             `);

                    //             $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons .visitorDetails span.visitorLogIconWithDetails`).append('<ul class="details"></ul>');

                    //             $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons .visitorDetails span.visitorLogIconWithDetails ul.details`).append(`
                    //                 <li>Returning Visitor - ${value.visitCount > 1 ? value.visitCount + ' visits': value.visitCount + ' visit'}</li>
                    //             `);
                    //         }

                    //         // visit log flag icon
                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails`)
                    //         .append(`<span class="visitorLogIconWithDetails flag" profile-header-text=""></span>`);

                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.flag`)
                    //         .append(`<img src='${matomoUrl}/${value.countryFlag}'>`);

                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.flag`)
                    //         .append(`<ul class="details"></ul>`);

                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails.flag ul.details`)
                    //         .append(`
                    //             <li>Country: ${value.country}</li>
                    //             <li>Region: ${value.region}</li>
                    //             <li>City: ${value.city}</li> 
                    //             <li>Browser language: ${value.language}</li>  
                    //             <li>IP: ${value.visitIp}</li>
                    //             <li>Visitor ID: ${value.visitorId}</li>
                    //         `);

                    //         // visit log browser icon
                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails`)
                    //         .append(`<span class="visitorLogIconWithDetails" profile-header-text="${value.browser}"></span>`);

                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.browser}"]`)
                    //         .append(`<img src="${matomoUrl}/${value.browserIcon}">`);

                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.browser}"]`)
                    //         .append(`<ul class="details"></ul>`);

                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.browser}"] ul.details`)
                    //         .append(`
                    //             <li>Browser: ${value.browser}</li>
                    //             <li>Browser engine: ${value.browserFamily}</li>
                    //             <li id="pluginlist_${index}" class="plugins">
                    //                 Plugins:
                    //             </li>
                    //         `);

                    //         // visit log operation system icon
                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails`)
                    //         .append(`<span class="visitorLogIconWithDetails" profile-header-text="${value.operatingSystem}"></span>`);

                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.operatingSystem}"]`)
                    //         .append(`<img src="${matomoUrl}/${value.operatingSystemIcon}">`);

                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.operatingSystem}"]`)
                    //         .append(`<ul class="details"></ul>`);

                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.operatingSystem}"] ul.details`)
                    //         .append(`
                    //             <li>Operating system: ${value.operatingSystemName} ${value.operatingSystemVersion}</li>
                    //         `);

                    //         // visit log resolution icon
                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails`)
                    //         .append(`<span class="visitorLogIconWithDetails" profile-header-text="${value.resolution}"></span>`);

                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.resolution}"]`)
                    //         .append(`<img src="${matomoUrl}/${value.deviceTypeIcon}">`);

                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.resolution}"]`)
                    //         .append(`<ul class="details"></ul>`);

                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .own-visitor-column .visitorLogIcons span.visitorDetails .visitorLogIconWithDetails[profile-header-text="${value.resolution}"] ul.details`)
                    //         .append(`
                    //             <li>Device type: ${value.deviceType}</li>
                    //             <li>Device brand: ${value.deviceBrand}</li>                
                    //             <li>Device model: ${value.deviceModel}</li>                
                    //             <li>Resolution: ${value.resolution}</li>  
                    //         `);


                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .visitorActions`).attr('id', `visitorActions_${index}`);

                    //         $(`#visitorcards li.card[data-log=${index}_${value.visitorId}] .visitorActions`).html(`
                    //             <strong>${value.actions > 1 ? value.actions + ' Actions' : value.actions + ' Action'}</strong>
                    //         `);
                            
                    //         $.each(value.pluginsIcons,function(i,v){
                    //             $(`#visitorcards .card #pluginlist_${index}`).append(`
                    //                 <img width="16px" height="16px" src="${matomoUrl}/${v.pluginIcon}" alt="${v.pluginName}">
                    //             `);
                    //         });
                    //         if(tts > 0){
                    //             let min = Math.floor(tts / 60);
                    //             let sec = tts - (Math.floor(tts / 60) * 60);
                    //             if(min <= 0){
                    //                 $(`#visitorcards .card #visitorActions_${index} strong`).append(` - ${sec}s`);
                    //             }else{
                    //                 if(sec > 0 ){
                    //                     $(`#visitorcards .card #visitorActions_${index} strong`).append(` - ${min} min ${sec}s`);
                    //                 }else{
                    //                     $(`#visitorcards .card #visitorActions_${index} strong`).append(` - ${min} min`);
                    //                 }
                    //             }
                    //         }
                    //         if(value.actions > 0){
                    //             $(`#visitorcards .card #visitorActions_${index}`).append(`<div class="visitor-log-page-list"></div>`);
                    //             $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list`).append('<ol class="visitorLog actionList"></ol>');

                    //         }

                    //         $.each(value.actionDetails, function(i,v){
                    //             if(v.type == 'action'){
                    //                 $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog`).append(`
                    //                     <li id="visitor_action_folder_${i}"
                    //                     class="action folder"
                    //                     title="${v.serverTimePretty} \n ${v.subtitle} \n ${v.pageLoadTime !== undefined ? `Page load time: ${v.pageLoadTime}` : ''} \n ${v.timeSpentPretty !== undefined ? `Time on page: ${v.timeSpentPretty}` : ''}
                    //                     "></li>
                    //                 `);
                    //                 $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog #visitor_action_folder_${i}`).append(`
                    //                     <div class="action_folder_inner"><span class="truncated-text-line">${v.title}</span></div>
                    //                 `);
                    //                 $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog #visitor_action_folder_${i} .action_folder_inner`).append(`
                    //                     <img src="${matomoUrl}/${v.iconSVG}" class="action-list-action-icon action">
                    //                 `);
                    //                 $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog #visitor_action_folder_${i} .action_folder_inner`).append(`
                    //                     <p><a href="${v.url}" target="_blank" rel="noreferrer noopener" class="action-list-url truncated-text-line" >${v.url}</a></p>
                    //                 `);
                    //             }
                    //             if(v.type != 'action' && $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog.actionList`).children('.action.folder').length > 0 && $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog .pageviewActions#pageviewActions_${index}`).length > 0){
                    //                 $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog .pageviewActions#pageviewActions_${index} .actionList`).append(`
                    //                     <li class="action outlink" title="${v.serverTimePretty} \n ${v.subtitle} \n ${v.timeSpentPretty !== undefined ? `Time on page: ${v.timeSpentPretty}` : ''}">
                    //                         <div class="outlink_folder_inner">
                    //                             <img src="${matomoUrl}/${v.iconSVG}" class="action-list-action-icon ${v.type}">
                    //                             <a href="${v.url}" rel="noreferrer noopener" target="_blank" class="action-list-url truncated-text-line">
                    //                                 ${v.url}
                    //                             </a>
                    //                         </div>
                    //                     </li>
                    //                 `);
                    //             }
                    //             if(v.type != 'action' && $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog.actionList`).children('.action.folder').length > 0 && $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog .pageviewActions#pageviewActions_${index}`).length == 0){
                    //                 // add action here from line 691
                    //                 $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog`).append(`
                    //                     <li id="pageviewActions_${index}" class="pageviewActions last-action" data-view-count="${v.pageviewPosition}">
                    //                         <ol class="actionList p-0">
                    //                         </ol>
                    //                     </li>
                    //                 `);
                    //                 $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog .pageviewActions#pageviewActions_${index} .actionList`).append(`
                    //                     <li class="action" 
                    //                         title="${v.serverTimePretty}
                    //                                 ${v.subtitle}
                    //                                 ${v.timeSpentPretty !== undefined ? `Time on page: ${v.timeSpentPretty}` : ''}">
                    //                         <div>
                    //                             <img src="${matomoUrl}/${v.iconSVG}" class="action-list-action-icon ${v.type}">
                    //                             <a href="${v.url}" rel="noreferrer noopener" target="_blank" class="action-list-url truncated-text-line">
                    //                                 ${v.url}
                    //                             </a>
                    //                         </div>
                    //                     </li>
                    //                 `);
                    //             }
                    //             if(v.type != 'action' && $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog.actionList`).children('.action.folder').length == 0) {
                    //                 $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog.actionList`).append(`
                    //                     <li class="action" 
                    //                         title="${v.serverTimePretty}
                    //                                 ${v.subtitle}
                    //                                 ${v.timeSpentPretty !== undefined ? `Time on page: ${v.timeSpentPretty}` : ''}">
                    //                         <div>
                    //                             <img src="${matomoUrl}/${v.iconSVG}" class="action-list-action-icon ${v.type}">
                    //                             <a href="${v.url}" rel="noreferrer noopener" target="_blank" class="action-list-url truncated-text-line">
                    //                                 ${v.url}
                    //                             </a>
                    //                         </div>
                    //                     </li>                                         
                    //                 `)
                    //             }
                    //         });

                    //         if($(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog .pageviewActions#pageviewActions_${index}`).length > 0){
                    //             let el = $(`#visitorcards .card #visitorActions_${index} .visitor-log-page-list .visitorLog .pageviewActions#pageviewActions_${index} .actionList`);
                    //             let lastchild = $(el).children('.action').last();
                    //             $(lastchild).addClass('last-action');
                    //         }
                    //     });
                    // }else{
                    //     $("#visitorcards").append(`<h2>Data not available</h2>`);
                    //     $("#visitorcards ").siblings('nav').remove();
                    // }
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
                success: function(response) {
                    let country = response.visitorProfile.countries[0].prettyName;
                    let city = response.visitorProfile.countries[0].cities[0];
                    let flag = matomoUrl+'/'+response.visitorProfile.countries[0].flag;
                    let lang = response.visitorProfile.lastVisits[0].language;
                    let visitIp = response.visitorProfile.lastVisits[0].visitIp;
                    let visitorId = response.visitorProfile.lastVisits[0].visitorId;
                    let browser = response.visitorProfile.lastVisits[0].browser
                    let browserIcon = matomoUrl+'/'+response.visitorProfile.lastVisits[0].browserIcon;
                    let browserFamily = response.visitorProfile.lastVisits[0].browserFamily;
                    let pluginIcons = response.visitorProfile.lastVisits[0].pluginsIcons;
                    let operatingSystem = response.visitorProfile.lastVisits[0].operatingSystem;
                    let operatingSystemIcon = matomoUrl+'/'+response.visitorProfile.lastVisits[0].operatingSystemIcon;
                    let resolution = response.visitorProfile.lastVisits[0].resolution;
                    let deviceTypeIcon = matomoUrl+'/'+response.visitorProfile.lastVisits[0].deviceTypeIcon;
                    let deviceType = response.visitorProfile.lastVisits[0].deviceType;
                    let deviceBrand = response.visitorProfile.lastVisits[0].deviceBrand;
                    let deviceModel = response.visitorProfile.lastVisits[0].deviceModel;
                    $('.modal-visitor-profile-info').remove();
                    $('.matomodash').after(response.visitorModal);
                    $('.modal-visitor-profile-info').attr('id', visitorId);
                    $(`.modal-visitor-profile-info#${visitorId} .visitor-profile-overview .visitor-profile-avatar img`).attr('src', `${matomoUrl}/plugins/Live/images/unknown_avatar.png`);
                    $(`.modal-visitor-profile-info#${visitorId} .visitor-profile-overview .visitor-profile-header .visitor-profile-id span`).text(`ID: ${visitorId}`);
                    
                    // visit summary flag 
                    $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails .visitorLogIconWithDetails.flag').attr('profile-header-text', city);
                    $(`.modal-visitor-profile-info .visitorLogIcons .visitorDetails span.visitorLogIconWithDetails.flag[profile-header-text="${city}"] img`).attr('src', flag);
                    $(`.modal-visitor-profile-info .visitorLogIcons .visitorDetails span.visitorLogIconWithDetails.flag[profile-header-text="${city}"] ul.details`).html(`
                        <li>Country: ${country}</li>
                        <li>City: ${city}</li>                
                        <li>Browser language: ${lang}</li>                                
                        <li>IP: ${visitIp}</li>
                        <li>Visitor ID: ${visitorId}</li>
                    `);

                    // visit summary browser
                    $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails .visitorLogIconWithDetails.browser').attr('profile-header-text', browser);
                    $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails .visitorLogIconWithDetails.browser img').attr('src', browserIcon);
                    $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails .visitorLogIconWithDetails.browser ul.details').html(`
                        <li>Browser: ${browser}</li>
                        <li>Browser engine: ${browserFamily}</li>
                        <li id="pluginlist_modal${visitorId}" class="plugins">Plugins:</li>
                    `);

                    $.each(pluginIcons,function(i,v){
                        let icon = matomoUrl+'/'+v.pluginIcon;
                        $(`.visitorLogIconWithDetails.browser ul.details #pluginlist_modal${visitorId}`).append(`<img width="16px" height="16px" src="${icon}" alt="${v.pluginName}">`);
                    });

                    // visit summary operating system
                    $('.modal-visitor-profile-info .visitorLogIcons .visitorLogIconWithDetails.operatingsystem').attr('profile-header-text', operatingSystem);
                    $('.modal-visitor-profile-info .visitorLogIcons .visitorLogIconWithDetails.operatingsystem img').attr('src', operatingSystemIcon);
                    $('.modal-visitor-profile-info .visitorLogIcons .visitorLogIconWithDetails.operatingsystem ul.details li').text(`Operating system: ${operatingSystem}`);


                    // visit summary resolution
                    $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails .visitorLogIconWithDetails.resolution').attr('profile-header-text', resolution);
                    $('.modal-visitor-profile-info .visitorLogIcons .visitorDetails .visitorLogIconWithDetails.resolution img').attr('src', deviceTypeIcon);
                    $(`.modal-visitor-profile-info .visitorLogIcons .visitorDetails .visitorLogIconWithDetails.resolution ul.details`).html(`
                            <li>Device type: ${deviceType}</li>
                            <li>Device brand: ${deviceBrand}</li> 
                            <li>Device model: ${deviceModel}</li>
                            <li>Resolution: ${resolution}</li>
                    `);

                    let totalVisitDurationPretty = response.visitorProfile.totalVisitDurationPretty;
                    let totalPageViews = response.visitorProfile.totalPageViews;
                    let totalVisits = response.visitorProfile.totalVisits;
                    let totalGoalConversions = response.visitorProfile.totalGoalConversions;
                    let averagePageLoadTime = response.visitorProfile.averagePageLoadTime;

                    if(response.visitorProfile.totalDownloads > 0) {
                        let totalActions = response.visitorProfile.totalActions;
                        let totalDownloads = response.visitorProfile.totalDownloads;
                        let totalOutlinks = response.visitorProfile.totalOutlinks > 0 ? response.visitorProfile.totalOutlinks == 1 ? response.visitorProfile.totalOutlinks+' Outlink' : response.visitorProfile.totalOutlinks+' Outlinks' : ''
                        let summary_text = `
                            Spent a total of <strong>${totalVisitDurationPretty}</strong> on the website, and performed 
                            <strong>${totalActions} ${totalActions == 1  ? 'action' : 'actions'}</strong> 
                            (
                                     ${totalPageViews} ${totalPageViews == 1 ? 'Pageview' : 'Pageviews'} 
                                     ${totalDownloads} ${totalDownloads == 1 ? 'Download' : 'Downloads'}, 
                                     ${totalOutlinks} 
                            )
                            in ${totalVisits} ${totalVisits == 1  ? 'visit' : 'visits'}.
                            <br>
                            converted ${totalGoalConversions == 1 ? totalGoalConversions+' Goal' : totalGoalConversions+' Goals'}
                            ${averagePageLoadTime !== undefined ? '<br>Each page took on average '+averagePageLoadTime+'s to load for this visitor.' : ''}
                        `;
                        $('.modal-visitor-profile-info .visitor-profile-summary .summary p').html(summary_text);
                    }

                    if(response.visitorProfile.totalDownloads == 0) {
                        let summary_text = `
                            Spent a total of <strong>${totalVisitDurationPretty}</strong> on the website, and viewed 
                            ${totalPageViews} ${totalPageViews == 1 ? 'Page' : 'Pages'}
                            in ${totalVisits} ${totalVisits == 1  ? 'visit' : 'visits'}.
                            <br>
                            converted ${totalGoalConversions == 1 ? totalGoalConversions+' Goal' : totalGoalConversions+' Goals'}
                            ${ averagePageLoadTime !== undefined ? '<br>Each page took on average '+averagePageLoadTime+'s to load for this visitor.' : ''}
                        `;
                        $('.modal-visitor-profile-info .visitor-profile-summary .summary p').html(summary_text);
                    }

                    let totalEcommerceRevenue = response.visitorProfile.totalEcommerceRevenue;
                    let totalEcommerceItems = response.visitorProfile.totalEcommerceItems;
                    let totalEcommerceConversions = response.visitorProfile.totalEcommerceConversions;

                    $('.modal-visitor-profile-info .visitor-profile-summary .ecommerce').html(`<p>Generated a Life Time Revenue of €${totalEcommerceRevenue}. Purchased ${totalEcommerceItems} items in ${totalEcommerceConversions} ecommerce orders.</p>`);

                    let first_visit_date = response.visitorProfile.firstVisit.prettyDate;
                    let first_visit_days_ago = response.visitorProfile.firstVisit.daysAgo;
                    let first_visit_referralSummary = response.visitorProfile.firstVisit.referralSummary;
                    let last_visit_date = response.visitorProfile.lastVisit.prettyDate;
                    let last_visit_days_ago = response.visitorProfile.lastVisit.daysAgo;
                    let last_visit_referralSummary = response.visitorProfile.lastVisit.referralSummary;
                    
                    $('.modal-visitor-profile-info .visitor-profile-summary .firstlastvisit .first_visit_outer .firstvisit').html(`<p>${first_visit_date} <span class="text-muted">- ${first_visit_days_ago} days ago</span> from <strong>${first_visit_referralSummary}</strong></p>`);
                    $('.modal-visitor-profile-info .visitor-profile-summary .firstlastvisit .last_visit_outer .lastvisit').html(`<p>${last_visit_date} <span class="text-muted">- ${last_visit_days_ago} days ago</span> from <strong>${last_visit_referralSummary}</strong></p>`);

                    let devices = response.visitorProfile.devices;

                    $(devices).each(function(i, v){
                        let apparaten = '';
                        let icon = matomoUrl+'/'+v.icon;
                        $(v.devices).each(function(index, value) { 
                            apparaten += value.name+"("+value.count+"x)";
                        });
                        $('.modal-visitor-profile-info .visitor-profile-summary .devices p img').attr('src', icon);
                        $('.modal-visitor-profile-info .visitor-profile-summary .devices p span').html(`&nbsp;<strong>${v.count}</strong> visits from <strong>${v.type} devices: ${apparaten}`);
                    });

                    let countries = response.visitorProfile.countries;
                    $(countries).each(function(i,v) {
                        let countryName = v.prettyName;
                        let cities = v.cities;
                        let nb_visits = v.nb_visits == 1 ? v.nb_visits+" visit": v.nb_visits+" visits";
                        let flag = matomoUrl+'/'+v.flag;
                        let city_names = '';
                        $(cities).each(function(index, value){ city_names = value});
                        let cities_text = `<strong>${nb_visits}</strong> from <span>${cities}</span>, ${v.prettyName}&nbsp;`;
                        if(Object.keys(cities).length > 1){
                            city_names = '';
                            for (let city in cities) {
                                if (cities.hasOwnProperty(city)) {
                                    city_names +=  cities[city]+"\n";
                                }
                            }
                            cities_text = `<strong>${nb_visits}</strong> from <span title="${city_names}">different cities</span> in ${countryName}&nbsp;`;
                        }
                        $('.modal-visitor-profile-info .visitor-profile-summary .location p').html(`${cities_text} `);
                        $('<img/>').attr({
                            src: flag,
                            height: '16px',
                            title: countryName
                        }).appendTo(".modal-visitor-profile-info .visitor-profile-summary .location p");
                        // $('.modal-visitor-profile-info .visitor-profile-summary .location p').append(`
                        //         <a class="visitor-profile-show-map d-none" href="#">(show&nbsp;map)</a> 
                        // `);
                    });
                    let lastVisits = response.visitorProfile.lastVisits;

                    let visitBlock = $('.visitor-profile-visits-info .visitblock');

                    $(lastVisits).each(function(i,v){
                        $(visitBlock).clone().appendTo('.visitor-profile-visits-info');
                        let getLastBlock = $('.visitor-profile-visits-info').children('.visitblock').last();
                        $(getLastBlock).attr('id', `visitblock_no_${i}`);
                        let thisBlock = $(`.visitor-profile-visits-info .visitblock#visitblock_no_${i}`);
                        $(thisBlock).removeClass('d-none');
                        let browserIcon = matomoUrl+'/'+v.browserIcon;
                        let deviceTypeIcon = matomoUrl+'/'+v.deviceTypeIcon;
                        let pluginIcons = v.pluginIcons;
                        let visitorProfileShowActionText = `${v.actions} ${v.actions == 1 ? 'action' : 'actions'} in ${v.visitDurationPretty}`;

                        $(thisBlock).find('.visitor-profile-visit-title span.counter').text(lastVisits.length - i);
                        $(thisBlock).find('.visitor-profile-visit-title .visitor-profile-visit-title visitor-profile-date').attr('title', (v.serverDatePrettyFirstAction+' '+v.serverTimePrettyFirstAction));
                        $(thisBlock).find('.visitor-profile-visit-title .visitor-profile-visit-title visitor-profile-date').text(v.serverDatePrettyFirstAction+' '+v.serverTimePrettyFirstAction);
                        $(thisBlock).find('.visitor-profile-visit-details').attr('id', 'visit'+(lastVisits.length - i));
                        $(thisBlock).find(`.visitor-profile-visit-details#${'visit'+(lastVisits.length - i)} .visitorDetails .visitorLogIconWithDetails.browser`).attr('profile-header-text', v.browser);
                        $(thisBlock).find(`.visitor-profile-visit-details#${'visit'+(lastVisits.length - i)} .visitorDetails .visitorLogIconWithDetails.operatingsystem`).attr('profile-header-text', v.operatingSystem);
                        $(thisBlock).find(`.visitor-profile-visit-details#${'visit'+(lastVisits.length - i)} .visitorDetails .visitorLogIconWithDetails.resolution`).attr('profile-header-text', v.resolution);
                        
                        $(thisBlock).find(`.visitor-profile-visit-details#${'visit'+(lastVisits.length - i)} .visitorDetails .visitorLogIconWithDetails.browser img`).attr('src', browserIcon);
                        $(thisBlock).find(`.visitor-profile-visit-details#${'visit'+(lastVisits.length - i)} .visitorDetails .visitorLogIconWithDetails.browser ul.details`).html(`
                            <li>Browser: ${v.browser}</li>
                            <li>Browser engine: ${v.browserFamily}</li>
                            <li id="pluginlist_modal${visitorId}_${i}" class="plugins">Plugins:</li>
                        `);

                        $(thisBlock).find(`.visitor-profile-visit-details#${'visit'+(lastVisits.length - i)} .visitorDetails .visitorLogIconWithDetails.operatingsystem img`).attr('src', operatingSystemIcon);
                        $(thisBlock).find(`.visitor-profile-visit-details#${'visit'+(lastVisits.length - i)} .visitorDetails .visitorLogIconWithDetails.operatingsystem ul.details li`).html(`
                            Operating system: ${v.operatingSystem}
                        `);

                        $(thisBlock).find(`.visitor-profile-visit-details#${'visit'+(lastVisits.length - i)} .visitorDetails .visitorLogIconWithDetails.resolution img`).attr('src', deviceTypeIcon);
                        $(thisBlock).find(`.visitor-profile-visit-details#${'visit'+(lastVisits.length - i)} .visitorDetails .visitorLogIconWithDetails.resolution ul.details`).html(`
                            <li>Device type: ${v.deviceType}</li>
                            <li>Device brand: ${v.deviceBrand}</li> 
                            <li>Device model: ${v.deviceModel}</li> 
                            <li>Resolution: ${v.resolution}</li> 
                        `);

                        $(thisBlock).find(`.visitor-profile-visit-details#${'visit'+(lastVisits.length - i)} a.visitor-profile-show-actions`).text(visitorProfileShowActionText);
                        
                        $(pluginIcons).each(function(index, value){
                            $(thisBlock).find(`.visitor-profile-visit-details#${'visit'+(lastVisits.length - i)} .visitorDetails #pluginlist_modal${visitorId}_${i}`).append(`
                                <img width="16px" height="16px" src="${matomoUrl}/${value.pluginIcon}" alt="${value.pluginName}">
                            `);
                        });
                        let actionBlock = $(thisBlock).find(`.visitor-profile-visit-details#${'visit'+(lastVisits.length - i)} ol.visitor-profile-actions.actionList .action`);

                        $(v.actionDetails).each(function(index, value){
                            let svgIcon = matomoUrl+'/'+value.iconSVG;
                            $(actionBlock).clone().appendTo($(thisBlock).find(`.visitor-profile-visit-details#${'visit'+(lastVisits.length - i)} ol.visitor-profile-actions.actionList`));
                            let getLastActionBlock = $(thisBlock).find(`.visitor-profile-visit-details#${'visit'+(lastVisits.length - i)} ol.visitor-profile-actions.actionList`).children('.action').last();
                            $(getLastActionBlock).attr('id', `actionBlock_${index}`);
                            let thisActionBlock = $(thisBlock).find(`ol.visitor-profile-actions.actionList .action#actionBlock_${index}`);
                            $(thisActionBlock).removeClass('d-none');
                            let actionTitle = `
                                ${value.serverTimePretty} \n
                                ${value.subtitle} \n
                                ${value.pageLoadTime !== undefined ? `Page load time: ${value.pageLoadTime} \n` : ''}
                                ${value.timeSpentPretty !== undefined ? `Time on page: ${value.timeSpentPretty}` : ''}
                            `;
                            
                            $(thisActionBlock).attr('title', actionTitle);
                            $(thisActionBlock).find('.truncated-text-line').text(value.title);
                            $(thisActionBlock).find('img').attr('src', svgIcon);
                            $(thisActionBlock).find('a.action-list-url').attr('href', value.url);
                            $(thisActionBlock).find('a.action-list-url').text(value.url);

                            switch(value.type){
                                case 'action':
                                    $(thisActionBlock).addClass('folder');
                                    break;
                                case 'outlink':
                                    $(thisActionBlock).addClass('outlink');
                                    $(thisActionBlock).addClass('ml-3');
                                case 'download':
                                    $(thisActionBlock).addClass('download');
                                    $(thisActionBlock).addClass('ml-3');
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