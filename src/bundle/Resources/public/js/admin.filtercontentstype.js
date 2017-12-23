(function () {
    const btn = document.querySelector('#edgarfiltercontentstype_locations_select_content');
    const udwContainer = document.getElementById('react-udw');
    const token = document.querySelector('meta[name="CSRF-Token"]').content;
    const siteaccess = document.querySelector('meta[name="SiteAccess"]').content;
    const closeUDW = () => udwContainer.innerHTML = '';
    const selectedLocationIds = document.querySelector('#edgarfiltercontentstype_locations_location');
    const selectedContentNames = document.querySelector('#selected_locations');
    const onConfirm = (form, content) => {
        arrayLocationIds = [];
        arrayContentNames = [];

        content.forEach(function (item) {
            arrayLocationIds.push(item.id);
            arrayContentNames.push('<li>' + item.ContentInfo.Content.Name + '</li>');
        });

        selectedLocationIds.value = arrayLocationIds.join(',');
        selectedContentNames.innerHTML = arrayContentNames.join('');

        closeUDW();
    };
    const onCancel = () => closeUDW();
    const openUDW = (event) => {
        event.preventDefault();

        selectedLocationIds.values = '';
        selectedContentNames.innerHTML = '';

        const form = document.querySelector('form[name="edgarfiltercontentstype"]');

        ReactDOM.render(React.createElement(eZ.modules.UniversalDiscovery, {
            onConfirm: onConfirm.bind(this, form),
            onCancel,
            startingLocationId: window.eZ.adminUiConfig.universalDiscoveryWidget.startingLocationId,
            restInfo: {token, siteaccess}
        }), udwContainer);
    };

    btn.addEventListener('click', openUDW, false);
})();
