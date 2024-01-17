import { Link } from "@inertiajs/react";
import { useEffect, useState } from "react";

export default function DataTable({ columns, data }) {
    const [tableData, setTableData] = useState({
        columns,
        data: data.data,
        selectHidden: false
    });

    useEffect(() => {
        setTableData(prevTableData => ({ ...prevTableData, data: data.data }));
    }, [data]);

    const toggleHiddenColumn = (key) => {
        setTableData((prevTableData) => ({
            ...prevTableData,
            selectHidden: false,
            columns: {
                ...prevTableData.columns,
                [key]: {
                    ...prevTableData.columns[key],
                    hidden: !prevTableData.columns[key].hidden
                }
            }
        }));
    }

    return (
        <div className="relative overflow-x-auto">
            <div className="flex justify-end w-full mb-2">
                <button onClick={() => setTableData({ ...tableData, selectHidden: !tableData.selectHidden })}
                    type="button" className="flex items-center gap-2 bg-white px-5 py-2.5 rounded-md shadow">
                    Hidden columns

                    <svg xmlns="http://www.w3.org/2000/svg" className={`transition duration-200 h-5 w-5 text-gray-400 ${tableData.selectHidden && 'rotate-180'}`} viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fillRule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clipRule="evenodd" />
                    </svg>
                </button>

                <div className={`${!tableData.selectHidden && 'hidden'} absolute right-3 top-10 mt-2 w-40 h-52 overflow-y-auto rounded-md bg-white shadow-md z-20`}>
                    {
                        Object.keys(tableData.columns).map(key => {
                            return (
                                <button onClick={() => toggleHiddenColumn(key)}
                                    className={`flex items-center gap-2 w-full first-of-type:rounded-t-md last-of-type:rounded-b-md px-4 py-2.5 text-left text-sm hover:bg-gray-50 ${tableData.columns[key].hidden && 'text-gray-500'}`}
                                    key={`hideBtn_${key}`}
                                >
                                    <span>{tableData.columns[key].remark}</span>
                                </button>
                            );
                        })
                    }
                </div>
            </div>
            <table className="w-full text-sm text-left rtl:text-right text-gray-500">
                <thead className="text-xs text-gray-700 uppercase bg-zinc-200">
                    <tr>
                        {
                            Object.keys(tableData.columns).map(key => {
                                if (tableData.columns[key].hidden) return;

                                return (
                                    <th scope="col" className="px-6 py-4" key={`th_${key}`}>
                                        {tableData.columns[key].remark}
                                    </th>
                                );
                            })
                        }
                    </tr>
                </thead>
                <tbody>
                    {
                        tableData.data.map((item) => (
                            <tr className="bg-white border-b hover:bg-gray-50" key={`tr_${item.id}`}>
                                {
                                    Object.keys(tableData.columns).map(key => {
                                        if (tableData.columns[key].hidden) return;

                                        return (
                                            <td scope="col" className="px-6 py-4" key={`td_${key}_${item.id}`}>
                                                {
                                                    typeof tableData.columns[key].callback === 'function' ?
                                                        tableData.columns[key].callback(item)
                                                        :
                                                        typeof item[key] === 'string' || typeof item[key] === 'number' ? item[key] : JSON.stringify(item[key])
                                                }
                                            </td>
                                        );
                                    })
                                }
                            </tr>
                        ))
                    }
                </tbody>
            </table>

            {
                data.last_page !== 1 &&
                <div className="w-fulll mt-3">
                    {
                        data.links.map((link, index) => (
                            <Link
                                key={index}
                                href={link.url}
                                dangerouslySetInnerHTML={{ __html: link.label }}
                                className={`px-4 py-2 border rounded ${!link.url ? 'text-gray-500' : 'text-gray-600 hover:bg-gray-100'}`}
                            />
                        ))
                    }
                </div>
            }
        </div>
    )
}