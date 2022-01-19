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
            <span id="visitip">
                IP: ${value.visitIp}
            </span>
            <br>
            <span id="visitor_city_span">
                <img width="16" class="flag" src="${matomoUrl}/${value.countryFlag}">&nbsp;
                ${value.city}
            </span>
        </span>
        <div class="visitorreferencearea">
        </div>
    </div> 
    <div class="col s12 m2 own-visitor-column"> 
        <span class="visitorLogIcons">
            <span class="visitorDetails">

            </span>
        </span>
    </div>
    <div id="visitorActions_${index}" class="col-6 s12 m7 column visitorActions">
        <strong>${value.actions > 1 ? value.actions + ' Actions' : value.actions + ' Action'}</strong>
    </div>
</div>