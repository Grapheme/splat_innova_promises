<?
    #Helper:dd($dic_id);
    $menus = array();
    $array = array();
    if (isset($root_category) && is_object($root_category))
        $array['category'] = $root_category->id;

    $menus[] = array(
        'link' => URL::route('catalog.attributes.index', $array),
        'title' => 'Все атрибуты',
        'class' => 'btn btn-default'
    );
    /*
    if (
        Allow::action($module['group'], 'categories_delete')
        && isset($element) && is_object($element) && $element->id
        && ($element->lft+1 == $element->rgt)
    ) {
        $menus[] = array(
            'link' => URL::route('catalog.category.destroy', array($element->id)),
            'title' => '<i class="fa fa-trash-o"></i>',
            'class' => 'btn btn-danger remove-category-record',
            'others' => [
                'data-goto' => URL::route('catalog.category.index'),
                'title' => 'Удалить запись'
            ]
        );
    }
    */
    /*
    if  (
        Allow::action($module['group'], 'attributes_edit')
        && isset($root_category) && is_object($root_category) && $root_category->id
    ) {
        $current_link_attributes = Helper::multiArrayToAttributes(Input::get('filter'), 'filter');
        $menus[] = array(
            'link' => URL::route('catalog.category.edit', array('id' => $root_category->id) + $current_link_attributes),
            'title' => 'Изменить',
            'class' => 'btn btn-success'
        );
    }
    */
    if  (Allow::action($module['group'], 'attributes_create')) {
        #$current_link_attributes = Helper::multiArrayToAttributes(Input::get('filter'), 'filter');

        $array2 = $array;
        if (
            isset($element) && is_object($element)
            && isset($element->attributes_group) && is_object($element->attributes_group)
        )
            $array2['group'] = $element->attributes_group->id;

        $menus[] = array(
            'link' => URL::route('catalog.attributes_groups.create', $array2),
            'title' => 'Добавить',
            'class' => 'btn btn-primary'
        );
    }

    #Helper::d($menus);
?>
    
    <h1>
        Атрибуты
        @if (isset($element) && is_object($element) && $element->name)

            @if (is_object($element->attributes_group))

                @if (is_object($element->attributes_group->category))

                    &nbsp;&mdash;&nbsp;
                    {{ $element->attributes_group->category->name }}
                @endif

                &nbsp;&mdash;&nbsp;
                {{ $element->attributes_group->name }}

            @endif

            &nbsp;&mdash;&nbsp;
            {{ $element->name }}

        @elseif (isset($root_category) && is_object($root_category) && $root_category->name)

            &nbsp;&mdash;&nbsp;
            {{ $root_category->name }}

            @if (NULL !== ($group_id = Input::get('group')) && isset($groups) && isset($groups[$group_id]))

                &nbsp;&mdash;&nbsp;
                {{ $groups[$group_id] }}

            @endif

        @endif
    </h1>

    {{ Helper::drawmenu($menus) }}
