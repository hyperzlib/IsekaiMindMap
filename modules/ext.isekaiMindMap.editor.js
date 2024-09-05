$(function () {
    console.log('Loading MindMap editor...');
    // Modify the editor
    // Add header offset
    $mwContentContainer = $('#mw-content-container');
    var offsetTop = $mwContentContainer.offset().top;

    var mindMapBasePath = mw.config.get("wgScriptPath") + '/extensions/IsekaiMindMap/public/';

    var $wpTextbox1 = $('#wpTextbox1');
    $wpTextbox1.hide();

    // var $headerOffset = $(`<div class="mindMapEditor-headerOffset" style="height: ${offsetTop}px; flex-basis: ${offsetTop}px;"></div>`);
    // $headerOffset.insertBefore($wpTextbox1);

    // Load MindMap Editor
    var mindMapData = $wpTextbox1.val();
    mindMapData = JSON.parse(mindMapData || '{}') || {};

    var defaultMindMapData = {
        root: {
            data: {
                text: '根节点'
            },
            children: []
        },
        theme: {
            template: 'blueSky',
            config: {}
        },
        layout: 'logicalStructure',
        config: {},
        view: null
    };

    mindMapData = Object.assign(defaultMindMapData, mindMapData);

    var editorUrl = `${mindMapBasePath}index.html?origin=${encodeURIComponent(window.location.origin)}`;
    var $mindMapEditor = $(`<iframe id="mindMapEditor" frameBorder="0" src="${editorUrl}"></iframe>`);
    $mindMapEditor.insertAfter($wpTextbox1);

    var elMindMapEditor = $mindMapEditor[0];

    var readyToSave = false;
    // detect whether the mindMapData has been saved to wpTextbox1 and ready to post
    var mindMapDataSaved = false;
    var onMindMapDataSaved = function () {
        if (readyToSave) {
            mindMapDataSaved = true;
            $editform.submit();
        }
    };

    // Listen to message from mindMapEditor
    window.addEventListener('message', function (event) {
        if (event.origin !== window.location.origin) {
            return;
        }

        var data = event.data;
        if (!data) return;

        switch (data.type) {
            case 'app_loaded':
                console.log('MindMapEditor loaded');
                elMindMapEditor.contentWindow.postMessage({
                    type: 'init_set_mind_map_data',
                    data: mindMapData
                }, '*');
                break;
            case 'app_inited':
                console.log('MindMapEditor initialized');
                break;
            case 'mind_map_data':
                const mindMapDataStr = JSON.stringify(data.data, null, 2);
                console.log('newMindMapData', mindMapDataStr);
                $wpTextbox1.val(mindMapDataStr);
                onMindMapDataSaved();
                break;
        }
    });

    var $editform = $('#editform');
    $editform.on('submit', function (e) {
        if (!mindMapDataSaved) {
            e.preventDefault();
            readyToSave = true;
            elMindMapEditor.contentWindow.postMessage({
                type: 'get_mind_map_data'
            }, '*');
        }
    });
});