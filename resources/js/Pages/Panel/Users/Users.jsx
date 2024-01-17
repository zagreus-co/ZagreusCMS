import DangerButton from '@/Components/DangerButton';
import DataTable from '@/Components/DataTable';
import PrimaryButton from '@/Components/PrimaryButton';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';
import moment from 'moment';

export default function Users({ auth, users }) {
    const { delete: destory, processing } = useForm();

    const DeleteUserById = (id) => {
        destory(route('panel.users.delete', id), {
            onSuccess: () => Toast.fire({ icon: "success", title: 'User has been deleted successfully.' })
        });
    }

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
                                    callback: ({ id }) => (
                                        <div className='space-x-1'>
                                            <Link href={route('panel.users.edit', id)}>
                                                <PrimaryButton>Edit</PrimaryButton>
                                            </Link>
                                            <DangerButton onClick={() => DeleteUserById(id)} disabled={processing}>Delete</DangerButton>
                                        </div>
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