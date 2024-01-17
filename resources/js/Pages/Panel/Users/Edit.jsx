import DataTable from '@/Components/DataTable';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';
import moment from 'moment';

export default function Users({ auth, user }) {

    const { data, setData, patch, processing, errors } = useForm({
        first_name: user.first_name,
        last_name: user.last_name,
        email: user.email,
        password: '',
    });

    function submit(e) {
        e.preventDefault()
        patch(route('panel.users.update', user.id), {
            onSuccess: () => Toast.fire({ title: "User updated successfully", icon: "success" })
        })
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            permissions={auth.permissions}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Create user</h2>}
        >
            <Head title="Create user" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-3">

                        <form onSubmit={submit} className='space-y-3'>
                            <div>
                                <InputLabel htmlFor="first_name" value="First name" />

                                <TextInput
                                    id="first_name"
                                    name="first_name"
                                    value={data.first_name}
                                    className="mt-1 block w-full"
                                    autoComplete="first_name"
                                    isFocused={true}
                                    onChange={(e) => setData('first_name', e.target.value)}
                                    required
                                />

                                <InputError message={errors.first_name} className="mt-2" />
                            </div>
                            <div>
                                <InputLabel htmlFor="last_name" value="Last name" />

                                <TextInput
                                    id="last_name"
                                    name="last_name"
                                    value={data.last_name}
                                    className="mt-1 block w-full"
                                    autoComplete="last_name"
                                    isFocused={true}
                                    onChange={(e) => setData('last_name', e.target.value)}
                                    required
                                />

                                <InputError message={errors.last_name} className="mt-2" />
                            </div>
                            <div>
                                <InputLabel htmlFor="email" value="Email address" />

                                <TextInput
                                    id="email"
                                    name="email"
                                    value={data.email}
                                    className="mt-1 block w-full"
                                    autoComplete="email"
                                    isFocused={true}
                                    onChange={(e) => setData('email', e.target.value)}
                                    required
                                />

                                <InputError message={errors.email} className="mt-2" />
                            </div>
                            <div>
                                <InputLabel htmlFor="password" value="Password" />

                                <TextInput
                                    type="password"
                                    id="password"
                                    name="password"
                                    value={data.password}
                                    className="mt-1 block w-full"
                                    autoComplete="password"
                                    onChange={(e) => setData('password', e.target.value)}
                                />

                                <InputError message={errors.password} className="mt-2" />
                            </div>

                            <PrimaryButton type="submit" disabled={processing}>Update user</PrimaryButton>
                        </form>

                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    )
}