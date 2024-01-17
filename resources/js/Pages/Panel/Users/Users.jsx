import DataTable from '@/Components/DataTable';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import moment from 'moment';

export default function Users({ auth, users }) {

    return (
        <AuthenticatedLayout
            user={auth.user}
            permissions={auth.permissions}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Users</h2>}
        >
            <Head title="Manage users" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className=" overflow-hidden shadow-sm sm:rounded-lg p-3">
                        <Link href={route('panel.users.create')}>Create user</Link>
                        <DataTable
                            columns={{
                                id: {
                                    remark: "#"
                                },
                                full_name: {
                                    remark: "Full name",
                                    callback: ({ first_name, last_name }) => `${first_name} ${last_name ?? ''}`
                                },
                                role: {
                                    remark: "Role",
                                    callback: ({ role }) => <span className='capitalize'>{role?.title ?? "Guest"}</span>
                                },
                                email: {
                                    remark: "Email",
                                    hidden: true
                                },
                                number: {
                                    remark: "Number",
                                    hidden: true
                                },
                                created_at: {
                                    remark: "Created at",
                                    callback: ({ created_at }) => moment(created_at).fromNow()
                                },
                                actions: {
                                    remark: '*',
                                    callback: () => (
                                        <>
                                            <button>Test Btn</button>
                                        </>
                                    )
                                }
                            }}
                            data={users}
                        />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}