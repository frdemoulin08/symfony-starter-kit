import { TabulatorFull as Tabulator } from 'tabulator-tables';

const buildSitesTable = (element) => {
    const ajaxUrl = element.dataset.tabulatorUrl;

    return new Tabulator(element, {
        layout: 'fitColumns',
        height: 'auto',
        placeholder: 'Aucun site configuré pour le moment.',
        pagination: true,
        paginationMode: 'remote',
        paginationSize: 10,
        paginationSizeSelector: [10, 25, 50],
        sortMode: 'remote',
        filterMode: 'remote',
        ajaxURL: ajaxUrl,
        ajaxConfig: 'GET',
        columns: [
            { title: 'Nom du site', field: 'name', minWidth: 200, headerFilter: 'input' },
            { title: 'Commune', field: 'city', minWidth: 160, headerFilter: 'input' },
            { title: 'Capacité', field: 'capacity', hozAlign: 'center', width: 120, headerFilter: 'input' },
            { title: 'Statut', field: 'status', width: 160, headerFilter: 'input' },
            { title: 'Mise à jour', field: 'updated_at', width: 160, headerFilter: 'input' },
        ],
    });
};

const TABLE_REGISTRY = {
    sites: buildSitesTable,
};

export const initTabulatorTables = () => {
    document.querySelectorAll('[data-tabulator]')
        .forEach((element) => {
            if (element.dataset.tabulatorInitialized === 'true') {
                return;
            }

            const key = element.dataset.tabulator;
            const builder = TABLE_REGISTRY[key];

            if (!builder) {
                return;
            }

            element.dataset.tabulatorInitialized = 'true';
            builder(element);
        });
};
