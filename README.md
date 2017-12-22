# remoteDBdiscovery
This extension of remotesDB is for the management of new remote controls. 

remoteDBdiscovery adds :
- 100+ protocols with IRP, in table irp_protocols, and a new table irp_dataprotocols with statistical data.
- A complete device type list to irp_devtypes.
- A tool to test any of 100+ protocols with any data: HEX or dataset.
- CRUD (Create, Read, Update, Delete) library, that allows fast and easy creation of new management pages for remotesDB tables.
- A complete workflow for add new remote controls to remotesDB

## Installation:
Precondition: last version of phpIRPlib (https://github.com/msillano/irp_classes) and remoteDB (https://github.com/msillano/remotesDB) installed and working.
- Copy all files on www/remoteDBdiscovery and updates on phpIRPlib and remoteDB.
- Import full_protocols.sql: It will add 100+ protocols to remotesDB.
- Import irp_protocoldata.sql: It will add a new table to remotesDB.
- Import view_protocoldata.sql: It will add a new view to remotesDB.
- Optionally this work with USBphpTunnel_fifo: https://github.com/msillano/USBphpTunnel_fifo
