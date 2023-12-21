async function getClientData(clientName, clientTel, clientEmail){
    const url = "getClients.php?cname=" + clientName + "&ctel=" + clientTel + "&cmail" + clientEmail;
    let response = await fetch(url);
    if(response.ok){
        response = await response.json();
        return response;
    }
    else
        return {
            error: "Failed to fetch data"
        };
}

async function displayClientData(tableEl, clientName, clientTel, clientEmail){
    if(clientName == undefined){
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

        if(client.imieNazwisko == " ")
            newCell1.textContent = client.firma;
        else
            newCell1.textContent = client.imieNazwisko;
        newCell2.textContent = client.ulica;
        newCell3.textContent = client.nr_domu;
        if(client.nr_lokalu != 0)
            newCell4.textContent = client.nr_lokalu;
        newCell5.textContent = client.kod_pocztowy;
        newCell6.textContent = client.miejscowosc;
        newCell7.textContent = client.telefon;
        newCell8.textContent = client.email;
    })
}

async function getDeviceData(serialNr){
    const url = "getDevices.php?serial=" + serialNr;
    let response = await fetch(url);
    if(response.ok){
        response = await response.json();
        return response;
    }
    else
        return {
            error: "Failed to fetch data"
        };
}

async function displayDeviceData(tableEl, serialNr){
    if(serialNr == undefined)
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
        newCell5.innerHTML = "<a href='sprzetSzczegoly.php?id=" + device.idUrzadzenia + "'>Zgłoszenia (" + device.liczbaZgloszen + ")</a>";
    })
}