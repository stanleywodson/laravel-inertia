import React, { useState } from 'react'
import Base from '../../Layouts/Base'
import Paginaitor from '../../Components/Paginaitor'
import useDialog from '../../Hooks/useDialog';
import Dialog from '../../Components/Dashboard/Dialog';
import CreateRole from '../../Components/Dashboard/Roles/CreateRole';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
export default function Index(props) {
    console.log('props: ', props);
    const {
        data: roles, links, meta
    } = props.roles; 
    const [addDialogHandler, addCloseTrigger,addTrigger] = useDialog()
    const [destroyDialogHandler, destroyCloseTrigger,destroyTrigger] = useDialog()
    const [UpdateDialogHandler, UpdateCloseTrigger,UpdateTrigger] = useDialog()
    const [state, setState] = useState([])

    const openUpdateDialog = (role) => {
        setState(role);
        UpdateDialogHandler()
    }

    const openDestroyDialog = (role) => 
    {
        setState(role);
        destroyDialogHandler()        
    };

    const destroyRole = () => 
    {
        Inertia.delete(route('roles.destroy', state.id),{ onSuccess: () => { destroyCloseTrigger() }});
    }

   
    return (
        <>
           <div className="container-fluid py-4">
                <Dialog trigger={addTrigger} title="Criar novo Perfil"> 
                    <CreateRole close={addCloseTrigger} isModel={false} />
                </Dialog>

                <Dialog trigger={UpdateTrigger} title={`Update User: ${state.name}`}> 
                    <CreateRole  close={UpdateCloseTrigger} isModel={true} model={state}/>
                </Dialog>


                <Dialog trigger={destroyTrigger} title={`Deletar Perfil: ${state.name}`}>
                    <p>Deleta este Perfil ?</p>
                    <div className="modal-footer">
                        <button type="button" className="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" onClick={destroyRole} className="btn bg-gradient-danger">Delete</button>
                    </div>
                </Dialog>
             

                <div className="row pb-4">
                    <div className="col-12 w-100">
                        <div className="card h-100 w-100">                            
                            <div className="card-header pb-0">
                            <div className="row">
                                <div className="col-md-6">
                                    <h6>Perfils do Sistema</h6>
                                </div>
                                <div className="col-md-6 d-flex justify-content-end">
                                    <button onClick={addDialogHandler} type="button" className="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal" data-bs-target="#exampleModalLabel">
                                        Criar Perfil
                                    </button>
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
                                        {roles.map((role, index) => (
                                            <tr key={role.id}>
                                                <td className='text-left'>
                                                    <p className="text-sm font-weight-bold mb-0">{role.name}</p>
                                                </td>
                                                <td className="align-middle text-center" width="10%">
                                                    <div>
                                                         <Link className={'btn btn-dark btn-icon-only'} href={route('roles.permissions.index',role.id)}>
                                                            <span className="btn-inner--icon"><i className="fas fa-eye"></i></span>
                                                        </Link>
                                                        <button type="button" onClick={() => openUpdateDialog(role)} className="btn btn-vimeo btn-icon-only mx-2">
                                                            <span className="btn-inner--icon"><i className="fas fa-pencil-alt"></i></span>
                                                        </button>
                                                        <button type="button" onClick={() => openDestroyDialog(role)} className="btn btn-youtube btn-icon-only">
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
