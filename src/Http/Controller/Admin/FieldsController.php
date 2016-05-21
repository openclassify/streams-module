<?php namespace Anomaly\StreamsModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Anomaly\Streams\Platform\Field\Form\FieldFormBuilder;
use Anomaly\Streams\Platform\Field\Table\FieldTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;

/**
 * Class FieldsController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 * @package       Anomaly\StreamsModule\Http\Controller\Admin
 */
class FieldsController extends AdminController
{

    /**
     * Return an index of existing fields.
     *
     * @param FieldTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(FieldTableBuilder $table)
    {
        $table->setNamespace('streams');

        return $table->render();
    }

    /**
     * Choose a field type for creating a field.
     *
     * @param FieldTypeCollection $fieldTypes
     * @return \Illuminate\View\View
     */
    public function choose(FieldTypeCollection $fieldTypes)
    {
        return $this->view->make('module::ajax/choose_field_type', ['field_types' => $fieldTypes]);
    }

    /**
     * Return the form for a new field.
     *
     * @param FieldFormBuilder    $form
     * @param FieldTypeCollection $fieldTypes
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(FieldFormBuilder $form, FieldTypeCollection $fieldTypes)
    {
        $form
            ->setNamespace('streams')
            ->setFieldType($fieldTypes->get($_GET['field_type']));

        return $form->render();
    }

    /**
     * Return the form for an existing field.
     *
     * @param FieldFormBuilder $form
     * @param                  $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(FieldFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
