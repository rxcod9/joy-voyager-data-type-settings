<?php

namespace Joy\VoyagerDataTypeSettings\Http\Traits;

trait CrudActions
{
    use IndexAction;
    use StoreAction;
    use UpdateAction;
    use DeleteAction;
    use MoveUpAction;
    use MoveDownAction;
    use DeleteValueAction;
}
