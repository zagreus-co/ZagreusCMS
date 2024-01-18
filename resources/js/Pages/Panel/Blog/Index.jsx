import ReactEditorJS from '@/Components/ReactEditorJS';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Index({ auth }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Blog</h2>}
        >
            <Head title="Manage blog" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">
                        <ReactEditorJS />

                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}