class Counter {
    constructor() {
        this.template = $('#counter_template').html();
        this.totalItem = 0;
        this.deletedItems = [];

        this.handleForm();
    }

    addNewAttribute() {
        let _self = this;
        let template = _self.template
            .replace(/__id__/gi, 0)
            .replace(/__name__/gi, '')
            .replace(/__count__/gi, '')
            .replace(/__order__/gi, '');
        $('.swatches-container .swatches-list').append(template);

        _self.totalItem++;
    }

    exportData() {
        let data = [];
        $('.swatches-container .swatches-list li').each((index, item) => {
            let $current = $(item);
            data.push({
                id: $current.data('id'),
                name: $current.find('.swatch-name input').val(),
                count: $current.find('.swatch-count input').val(),
                order: $current.find('.swatch-order input').val(),
            });
        });

        return data;
    }

    handleForm() {
        let _self = this;
        $('.swatches-container .swatches-list').sortable();

        $('body')
            .on('submit', () => {
                let data = _self.exportData();
                $('#counters').val(JSON.stringify(data));
                $('#deleted_counters').val(JSON.stringify(_self.deletedItems));
            })
            .on('click', '.js-add-new-counter', e => {
                e.preventDefault();
                _self.addNewAttribute();
            })
            .on('click', '.swatches-container .swatches-list li .remove-item a', event => {
                event.preventDefault();

                let $item = $(event.currentTarget).closest('li');

                _self.deletedItems.push($item.data('id'));

                $item.remove();
            });
    }
}

$(window).on('load', () => {
    new Counter;
});

