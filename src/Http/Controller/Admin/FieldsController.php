<?php namespace Anomaly\StreamsModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeCollection;
use Anomaly\Streams\Platform\Field\Form\FieldFormBuilder;
use Anomaly\Streams\Platform\Field\Table\FieldTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\StreamsModule\Http\Middleware\AuthorizeNamespace;
use Anomaly\StreamsModule\Http\Middleware\SetCheckNamespace;
use Illuminate\Session\Store;

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
     * The working namespace.
     *
     * @var string
     */
    protected $namespace;

    /**
     * Create a new StreamsController instance.
     *
     * @param Store $session
     */
    public function __construct(Store $session)
    {
        $this->middleware(SetCheckNamespace::class);
        $this->middleware(AuthorizeNamespace::class);

        $this->namespace = $session->get('anomaly.module.streams::namespace');

        parent::__construct();
    }

    /**
     * Return an index of existing fields.
     *
     * @param FieldTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(FieldTableBuilder $table)
    {
        $table
            ->setOption('heading', 'module::admin/groups/heading')
            ->setNamespace($this->getNamespace());

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
        return $this->view->make('module::admin/fields/choose', ['field_types' => $fieldTypes]);
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
            ->setNamespace($this->getNamespace())
            ->setOption('heading', 'module::admin/groups/heading')
            ->setFieldType($fieldTypes->get($this->request->get('field_type')));

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
        return $form
            ->setOption('heading', 'module::admin/groups/heading')
            ->render($id);
    }

    /**
     * Get the namespace.
     *
     * @return string
     */
    protected function getNamespace()
    {
        return $this->namespace;
    }
}
