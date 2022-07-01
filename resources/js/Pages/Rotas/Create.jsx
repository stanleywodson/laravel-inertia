
import React, { useState } from 'react'
import Base from '../../Layouts/Base'
import {addRouteInDb} from '../../services/request/routes'
export default function Create(props) {
   
    const {permissions} =  props
   
    const [items, setItems] = useState(permissions)

    function submitAddRoute(permission)
    {
        addRouteInDb(permission)
        setItems(items.filter( resp => resp.item != permission.item ))
    }
    return (
        <>
           <div className='container'>
                 <div className="card">
                    <div className="card-head p-2">
                        <h4>Lista de Rotas</h4>
                    </div>
                    <div className="card-body"> 
                        <div className="row">
                            {
                                !items.length && <span>Nenhuma rota nova</span>
                            }
                            {
                                items.map((resp,index) => (
                                    <div  className="col-md-4   d-inline-flex justify-content-around" key={index}>
                                        <span className='mr-3'>{resp.item}</span> <button onClick={() => submitAddRoute(resp)} className='ml-3 btn btn-success btn-sm'>add</button>
                                    </div>
                               
                                ))
                            }
                        </div>
                    </div>
                 </div>
            </div> 
        </>
    )
}

Create.layout = (page) => <Base key={page} children={page} title={"Adicionar Rotas no Banco de dados"}/>
