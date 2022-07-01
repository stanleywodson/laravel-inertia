import React, { useState } from 'react'
import Base from '../../Layouts/Base'
import { Link } from '@inertiajs/inertia-react';
import Paginaitor from '../../Components/Paginaitor'



export default function Index(props) {
    const {
        data: permissions, links, meta
    } = props.permissions; 

    return (
        <>
           <div className="container-fluid py-4">
                <div className="row pb-4">
                    <div className="col-12 w-100">
                        <div className="card h-100 w-100">                            
                            <div className="card-header pb-0">
                            <div className="row">
                                <div className="col-md-6">
                                    <h6>Permissões</h6>
                                </div>
                                <div className="col-md-6 d-flex justify-content-end">
                                     <Link className="btn bg-gradient-success btn-block mb-3" href={route('routes.create')}>
                                        ADICIONAR ROTAS
                                    </Link>
                                </div>
                            </div>
                            </div>
                            <div className="card-body px-0 pt-0 pb-2">
                            <div className="table-responsive-xxl p-2" width="100%">
                                <table className="table align-items-center justify-content-center mb-0" width="100%">
                                    <thead>
                                        <tr>
                                            <th className="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 text-left">Name</th>
                                            <th className="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">AÇÕES</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {permissions.map((permission, index) => (
                                            <tr key={permission.id}>
                                                <td className='text-left'>
                                                    <p className="text-sm font-weight-bold mb-0">{permission.name}</p>
                                                </td>
                                                <td className="align-middle text-center" width="10%">
                                                    <div>
                                                        <button type="button" onClick={() => false } className="btn btn-youtube btn-icon-only">
                                                            <span className="btn-inner--icon"><i className="fas fa-trash"></i></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <Paginaitor meta={meta} />
            </div>
        </>
    )
}

Index.layout = (page) => <Base key={page} children={page} title={"Todas as Rotas"}/>
