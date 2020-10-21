## Bulk Actions:

JS fayl: **theme/components/table-actions.js**

--

### Quick edit:

`MyController.php` ga yoziladigan kod:

```

public function actionIndex()
{
    [...]

    // Get post var
    $ajax = input_post('ajax');

    if ($ajax_action == 'quick-action') {
        $output['error'] = true;
        $output['success'] = false;

        $ajax_type = input_post('type'); // Action type
        $ajax_item_id = input_post('id'); // Element ID si

        if ($ajax_type == 'get_item') {
            [...]
            // Kerakli funksiyalar bajariladi

            $object = SomeModel($ajax_item_id);

            if ($object) {
                $output['error'] = false;
                $output['success'] = true;
                $output['item'] = $object;
            }
        }

        echo json_encode($output);
        exit();
    }

    [...]
}

```

`view.php` ga yoziladigan kod:

```
[...]

<div class="table-responsive">
    [...]

    <table class="table mb-0">
        <thead class="thead-light">
            [...]
        </thead>
        <tbody>
            <tr>
                [...]
                <td class="ta-icons-block">
                    [...]
                    <div class="ta-icons-in">
                        <a href="javascript:void(0);" data-action="quick-edit" data-action-id="10">
                            <i class="ri-edit-fill" data-toggle="tooltip" data-placement="top" title="Quick edit"></i>
                        </a>
                    </div>
                    [...]
                </td>
            </tr>
        </tbody>
    </table>
</div>

[...]

<?php
$this->registerJs(<<<JS

$(document).ready(function() {
    $(document).on('click', '[data-action="quick-edit"]', function () {
        var id = $(this).attr('data-action-id');
        
        tableQuickActionEdit({
            title: 'Quick edit',
            size: 'large', // large, x-large, small
            data: {
                ajax: 'quick-action',
                type: 'get_item',
                id: id,
            },
            fields: {
                title: {
                    id: 'category_title',
                    name: 'Title',
                    type: 'text',
                    required: true,
                    col: 'col-12',
                },
                slug: {
                    id: 'category_slug',
                    name: 'Slug',
                    type: 'text',
                    required: false,
                    col: 'col-6',
                },
                sort: {
                    id: 'category_sort',
                    name: 'Sort',
                    type: 'number',
                    required: false,
                    col: 'col-6',
                },
                icon: {
                    id: 'category_icon',
                    name: 'Icon',
                    type: 'image',
                    required: true,
                    col: 'col-6',
                },
                parent: {
                    id: 'category_parent',
                    name: 'Parent',
                    type: 'select',
                    required: true,
                    options: {
                        '': '-', 
                        'one': 'One', 
                        'two': 'Two', 
                        'three': 'Three',
                    },
                    col: 'col-6',
                },
                description: {
                    id: 'category_description',
                    name: 'Description',
                    type: 'textarea',
                    required: true,
                    height: 200,
                    col: 'col-12',
                },
            }
        });
    });
});

JS);
?>
```

--

### Quick create:

`MyController.php` ga yoziladigan kod:

```

public function actionIndex()
{
    [...]

    // Get post var
    $ajax = input_post('ajax');

    if ($ajax_action == 'quick-action') {
        $output['error'] = true;
        $output['success'] = false;

        $ajax_type = input_post('type'); // Action type

        if ($ajax_type == 'create') {
            [...]
            // Kerakli funksiyalar bajariladi

            $object = SomeModel($ajax_item_id);

            if ($object) {
                $output['error'] = false;
                $output['success'] = true;
                $output['message'] = 'New category has been successfully created.';
            }
        }

        echo json_encode($output);
        exit();
    }

    [...]
}

```

`view.php` ga yoziladigan kod:

```
[...]

<div>
    [...]
    
    <a href="#" data-action="quick-create" class="btn btn-info waves-effect">
        Add new
    </a>

    [...]
</div>

[...]

<?php
$this->registerJs(<<<JS

$(document).ready(function() {
    $([data-action="quick-create"]).click(function (e) {
        e.preventDefault();

        tableQuickActionCreate({
            title: 'Quick create',
            size: 'large', // large, x-large, small
            data: {
                ajax: 'quick-action',
                type: 'create',
            },
            fields: {
                title: {
                    id: 'category_title',
                    name: 'Title',
                    type: 'text',
                    required: true,
                    col: 'col-12',
                },
                slug: {
                    id: 'category_slug',
                    name: 'Slug',
                    type: 'text',
                    required: false,
                    col: 'col-6',
                },
                sort: {
                    id: 'category_sort',
                    name: 'Sort',
                    type: 'number',
                    required: false,
                    col: 'col-6',
                },
                icon: {
                    id: 'category_icon',
                    name: 'Icon',
                    type: 'image',
                    required: true,
                    col: 'col-6',
                },
                parent: {
                    id: 'category_parent',
                    name: 'Parent',
                    type: 'select',
                    required: true,
                    options: {
                        '': '-', 
                        'one': 'One', 
                        'two': 'Two', 
                        'three': 'Three',
                    },
                    col: 'col-6',
                },
                description: {
                    id: 'category_description',
                    name: 'Description',
                    type: 'textarea',
                    required: true,
                    height: 200,
                    col: 'col-12',
                },
            }
        });
    });
});

JS);
?>
```