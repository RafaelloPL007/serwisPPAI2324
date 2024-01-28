async function getClientData(clientName, clientTel, clientEmail) {
    const url = "php/getClients.php";
    const formData = new FormData();
    formData.append('cname', clientName);
    formData.append('ctel', clientTel);
    formData.append('cmail', clientEmail);

    let response = await fetch(url, {
        method: 'POST',
        body: formData
    });

    if (response.ok) {
        response = await response.json();
        return response;
    }
    else
        return {
            error: "Failed to fetch data"
        };
}

async function displayClientData(tableEl, clientName, clientTel, clientEmail) {
    if (clientName == undefined) {
        clientName = "";
        clientTel = "";
        clientEmail = "";
    }
    const data = await getClientData(clientName, clientTel, clientEmail);
    tableEl.innerHTML = "";
    data.forEach(client => {
        let newRow = tableEl.insertRow(-1);
        let newCell1 = newRow.insertCell(-1);
        let newCell2 = newRow.insertCell(-1);
        let newCell3 = newRow.insertCell(-1);
        let newCell4 = newRow.insertCell(-1);
        let newCell5 = newRow.insertCell(-1);
        let newCell6 = newRow.insertCell(-1);
        let newCell7 = newRow.insertCell(-1);
        let newCell8 = newRow.insertCell(-1);
        let newCell9 = newRow.insertCell(-1);

        if (client.imieNazwisko == " ")
            newCell1.textContent = client.firma;
        else
            newCell1.textContent = client.imieNazwisko;
        newCell2.textContent = client.ulica;
        newCell3.textContent = client.nr_domu;
        if (client.nr_lokalu != 0)
            newCell4.textContent = client.nr_lokalu;
        newCell5.textContent = client.kod_pocztowy;
        newCell6.textContent = client.miejscowosc;
        newCell7.textContent = client.telefon;
        newCell8.textContent = client.email;
        newCell9.innerHTML = "<a href='klientSzczegoly.php?id=" + client.id + "'>Zgłoszenia (" + client.aktywneZgloszenia + "/" + client.liczbaZgloszen + ")</a>";
    })
}

async function getDeviceData(serialNr) {
    const url = "php/getDevices.php";
    const formData = new FormData();
    formData.append('serial', serialNr);

    let response = await fetch(url, {
        method: 'POST',
        body: formData
    });

    if (response.ok) {
        response = await response.json();
        return response;
    }
    else
        return {
            error: "Failed to fetch data"
        };
}

async function displayDeviceData(tableEl, serialNr) {
    if (serialNr === undefined)
        serialNr = "";
    const data = await getDeviceData(serialNr);
    tableEl.innerHTML = "";
    data.forEach(device => {
        let newRow = tableEl.insertRow(-1);
        let newCell1 = newRow.insertCell(-1);
        let newCell2 = newRow.insertCell(-1);
        let newCell3 = newRow.insertCell(-1);
        let newCell4 = newRow.insertCell(-1);
        let newCell5 = newRow.insertCell(-1);

        newCell1.textContent = device.nrSeryjny;
        newCell2.textContent = device.producent;
        newCell3.textContent = device.model;
        newCell4.textContent = device.kategoria;
        newCell5.innerHTML = "<a href='sprzetSzczegoly.php?id=" + device.idUrzadzenia + "'>Zgłoszenia (" + device.aktywneZgloszenia + "/" + device.liczbaZgloszen + ")</a>";
    })
}

async function getReportData(k, p, s) {
    const url = "php/getReports.php";
    const formData = new FormData();
    formData.append('id-kl-s', k);
    formData.append('id-pr-s', p);
    formData.append('id-urz-s', s);

    let response = await fetch(url, {
        method: 'POST',
        body: formData
    });

    if (response.ok) {
        response = await response.json();
        return response;
    }
    else
        return {
            error: "Failed to fetch data"
        };
}

async function displayReportData(tableEl, k, p, s) {
    if (k === undefined)
        k = 0;
    if (p === undefined)
        p = 0;
    if (s === undefined)
        s = 0;
    const data = await getReportData(k, p, s);
    tableEl.innerHTML = "";
    data.forEach(report => {
        let newRow = tableEl.insertRow(-1);
        newRow.setAttribute("id", "zgl-" + report.id)
        let newCell1 = newRow.insertCell(-1);
        let newCell2 = newRow.insertCell(-1);
        let newCell3 = newRow.insertCell(-1);
        newCell3.classList.add("data-odbioru");
        let newCell4 = newRow.insertCell(-1);
        let newCell5 = newRow.insertCell(-1);
        let newCell6 = newRow.insertCell(-1);
        let newCell7 = newRow.insertCell(-1);
        newCell3.classList.add("status");
        let newCell8 = newRow.insertCell(-1);
        let newCell9 = newRow.insertCell(-1);
        newCell3.classList.add("buttons");

        newCell1.textContent = report.opis;
        newCell2.textContent = report.dataZg;
        newCell3.textContent = report.data_od;
        if (report.klient1 != "")
            newCell4.innerHTML = "<a href='klientSzczegoly.php?id=" + report.idk + "'>" + report.klient1 + "</a>";
        else
            newCell4.innerHTML = "<a href='klientSzczegoly.php?id=" + report.idk + "'>" + report.klient2 + "</a>";
        newCell5.innerHTML = "<a href='pracownikSzczegoly.php?id=" + report.idp + "'>" + report.pracownik + "</a>";
        newCell6.innerHTML = "<a href='sprzetSzczegoly.php?id=" + report.idu + "'>" + report.sprzet + "</a>";
        newCell7.textContent = report.status;
        newCell8.innerHTML = "<a href='czynnosciSerwisowe.php?zgl=" + report.id + "'>Czynności (" + report.liczbaCzynnosci + ")</a>";
        if (report.data_od == "Nieodebrane")
            newCell9.innerHTML += "<button class='end'>Odbiór</button>";
        else
            newCell9.innerHTML += "<button class='restart'>Anuluj odbiór</button>";
        if (report.status != "Przyjęto w oddziale")
            newCell9.innerHTML += "<button class='status-btn prev-status'>Poprz. status</button>";
        else
            newCell9.innerHTML += "<button class='status-btn prev-status' hidden>Poprz. status</button>";
        if (report.status != "Gotowy do odbioru")
            newCell9.innerHTML += "<button class='status-btn next-status'>Nast. status</button>";
        else
            newCell9.innerHTML += "<button class='status-btn next-status' hidden>Nast. status</button>";
    })
}

function changeOdb() {
    let end = true;
    if (event.target.classList.contains("restart")) end = false;
    const rowEl = event.target.parentNode.parentNode;
    const sendData = {
        id: rowEl.getAttribute("id").substring(4),
        endZgl: end
    };
    $.ajax({
        type: "POST",
        url: "php/finishZgl.php",
        data: sendData
    }).done(resp => {
        rowEl.querySelector(".data-odbioru").textContent = resp;
        let btnEl = rowEl.querySelector(".buttons .end");

        if (btnEl == undefined) {
            let btnEl = rowEl.querySelector(".buttons .restart");
            btnEl.textContent = "Odbiór";
            btnEl.classList.remove("restart");
            btnEl.classList.add("end");
        } else {
            btnEl.textContent = "Anuluj odbiór";
            btnEl.classList.remove("end");
            btnEl.classList.add("restart");
        }
    })
}

function changeStatus() {
    const rowEl = event.target.parentNode.parentNode;
    const currStatus = rowEl.querySelector(".status").textContent;
    let statusId = STATUSY.indexOf(currStatus);
    if (event.target.classList.contains("prev-status")) statusId--;
    else if (event.target.classList.contains("next-status")) statusId++;

    if (statusId > -1 && statusId < STATUSY.length) {
        const sendData = {
            id: rowEl.getAttribute("id").substring(4),
            status: STATUSY[statusId]
        };
        $.ajax({
            type: "POST",
            url: "php/changeStatus.php",
            data: sendData
        }).done(resp => {
            rowEl.querySelector(".status").textContent = STATUSY[statusId];

            if (statusId == 0)
                rowEl.querySelector(".prev-status").setAttribute("hidden", "hidden");
            else
                rowEl.querySelector(".prev-status").removeAttribute("hidden");

            if (statusId == STATUSY.length - 1)
                rowEl.querySelector(".next-status").setAttribute("hidden", "hidden");
            else
                rowEl.querySelector(".next-status").removeAttribute("hidden");
        })
    }
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}

function validatePhoneNumber(phoneNumber) {
    const re = /^[\d+ -]+$/;
    return re.test(phoneNumber);
}
