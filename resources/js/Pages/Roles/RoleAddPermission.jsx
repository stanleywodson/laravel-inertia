import React from 'react'
import Base from '../../Layouts/Base'
import Paginaitor from '../../Components/Paginaitor'
import { Link } from '@inertiajs/inertia-react';
import {addPermissionInRole} from '../../services/request/rolepermission'
import toast from 'react-hot-toast'

export default function RoleAddPermission(props) {
    const {permissions: {data:permissionsArr,links,meta}, role} = props
    function isPermissionInRole(permissi)
    {
        if(role.permissions.find(permission => permission.id == permissi)){
            return true;
        }
        return false;
    }

    const onSubmitPermission = (e,permission,status) => {
        const {
            dataset: {remove}
        } = e.target
        let texto = 'removida';
        console.log('e: ', e);
        if(remove == 'adicionar'){
            e.target.dataset.remove = 'remover'
            e.target.classList.remove('btn-dark')
            e.target.classList.add('btn-success')
            e.target.innerText = 'remover'
            texto = 'adicionada'
        }else{
            e.target.dataset.remove = 'adicionar'
            e.target.classList.remove('btn-success')
            e.target.classList.add('btn-dark')
            e.target.innerText = 'adicionar'
        }
        
        
        const content = { ...permission, status:remove,role:role.id}
        addPermissionInRole(content)
        toast(`Permissao ${texto}`, {
            duration: 4000,
            position: 'top-right',
            icon: '👏'
        })
    }



    return (
        <>
           <div className="container-fluid py-4">
                <div className="row pb-4">
                    <div className="col-12 w-100">
                        <div className="card h-100 w-100">                            
                            <div className="card-header pb-0">
                            <div className="row">
                                <div className="col-md-6">
                                    <h6>Permissões do Perfil {role.name}</h6>
                                </div>
                                <div className="col-md-6 d-flex justify-content-end">
                                    <Link className={'btn btn-dark'} href={route('roles.index')}>
                                        VOLTAR
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
                                        {permissionsArr?.map((permission, index) => (
                                            <tr key={permission.id}>
                                                <td className='text-left'>
                                                    <p className="text-sm font-weight-bold mb-0">{permission.name}</p>
                                                </td>
                                                <td className="align-middle text-center" width="10%">
                                                    <div>
                                                    <button
                                                 
                                                    
                                                     data-remove={ isPermissionInRole(permission.id) ? 'remover' : 'adicionar' }
                                                     type="button" 
                                                     onClick={(e) => onSubmitPermission(e,permission)}  
                                                     className={`btn   ${isPermissionInRole(permission.id) ? 'btn-success' : 'btn-dark'}`}>
                                                       { isPermissionInRole(permission.id) ? 'remover' : 'adicionar' }
                                                    </button>
                                                        {/* {
                                                            isPermissionInRole(permission.id) ? (
                                                                <button id="btn_rmv" data-remove="remover" type="button" onClick={(e) => onSubmitPermission(e,permission,'remover')}  className="btn btn-success btn-icon-only">
                                                                    <span className="btn-inner--icon"><i className="fas fa-key"></i></span>
                                                                </button>
                                                            ) : (
                                                                <button data-remove="adicionar" type="button" onClick={(e) => onSubmitPermission(e,permission,'adicionar')}  className="btn btn-dark btn-icon-only">
                                                                    <span className="btn-inner--icon"><i className="fas fa-key"></i></span>
                                                                </button>
                                                            )
                                                        } */}
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

RoleAddPermission.layout = (page) => <Base key={page} children={page} title={"Todas as Rotas"}/>
