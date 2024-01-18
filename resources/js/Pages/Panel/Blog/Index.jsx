import ReactEditorJS from '@/Components/Editor/ReactEditorJS';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import { useRef, useState } from 'react';

export default function Index({ auth }) {
    const [counter, setCounter] = useState(0);

    const editor = useRef(null);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Blog</h2>}
        >
            <Head title="Manage blog" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">
                        <button onClick={() => {
                            editor.current.save()
                                .then((output) => {
                                    setCounter(counter + 1)
                                    console.log(JSON.stringify(output))
                                }
                                )
                                .catch((error) => {
                                    console.error('ReactEditorJS: Saving failed: ', error)
                                });
                        }}>
                            {counter} Click
                        </button>
                        <ReactEditorJS editor={editor}
                            placeholder="Start writing your awesome article!" />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}