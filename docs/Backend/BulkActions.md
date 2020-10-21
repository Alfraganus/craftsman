## Bulk Actions:

JS fayl: **theme/components/table-actions.js**

--

### Qo'llanma:

BulkActions

`MyController.php` ga yoziladigan kod:

```

public function actionIndex()
{
    [...]

    // Get post var
    $ajax = input_post('ajax');

    if ($ajax == 'bulk-actions') {
        $output['error'] = true;
        $output['success'] = false;

        $ajax_action = input_post('action'); // Action nomi
        $ajax_items = input_post('items'); // Select qilingan elementlar ID si

        if ($ajax_action == 'publish') {
            [...]
            // Kerakli funksiyalar bajariladi

            $done = SomeModel($ajax_items);

            if ($done == "OK") {
                // Select qilingan ID lar
                $output['error'] = false;
                $output['success'] = true;
                $output['message'] = 'Selected items have been successfully published.';
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
use \backend\widgets\TableActions;

[...]

<div>
    <?php 
    // Bu arraydagilarni barchasi default bilgilardir.
    // Kerakli bo'lgan bilgilarni qoldirib qolganini o'chiramiz.
    // Bosh array yuborsak default bilgilar keladi.

    $array = array(
        'show_clang' => true,
        'limit_default' => 20,
        'sort_default' => 'newest,
        'actions' => array(
            'publish',
            'unpublish',
            'trash',
            'restore',
            'delete'
        ),
        'limit_array' => array(
            20 => '20 items',
            40 => '40 items',
            60 => '60 items',
            100 => '100 items',
            200 => '200 items',
        ),
        'sort_array' => array(
            'newest' => 'Newest',
            'oldest' => 'Oldest',
            'a-z' => 'A-Z',
            'z-a' => 'Z-A',
        )
    );

    echo BulkActions::widget($array); ?>
</div>

[...]

<div class="table-responsive table-with-actions">
    <input type="hidden" id="table-selected-items" ta-selected-items>

    <table class="table mb-0">
        <thead class="thead-light">
            <tr>
                <th width="30px" class="ta-select-icon">
                    <i class="ri-checkbox-blank-line" data-ta-select-all></i>
                </th>
                [...]
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="ta-select-icon">
                    <i class="ri-checkbox-blank-line" data-ta-select="{id}"></i>
                </td>
                [...]
            </tr>
        </tbody>
    </table>
</div>
```