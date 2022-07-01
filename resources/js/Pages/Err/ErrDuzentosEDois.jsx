
import React from 'react'
import Base from '../../Layouts/Base'

export default function ErrDuzentosEDois() {
    return (
        <>
            <div className="container-fluid py-4">
            
                <div className="row pb-4">
                    <div className="col-12 w-100">
                        <div className="card h-100 w-100">                            
                            <div className="card-header pb-0">
                            <div className="row">
                                <div className="col-md-6">
                                    <h6>Users table</h6>
                                </div>
                                <div className="col-md-6 d-flex justify-content-end">
                                  
                                </div>
                            </div>
                            </div>
                            <div className="card-body px-0 pt-0 pb-2">
                            <div className="table-responsive-xxl p-0" width="100%">
                               <h1>ErrDuzentosEDois</h1>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </>
    )
}

ErrDuzentosEDois.layout = (page) => <Base key={page} children={page} title={"Manage Users"}/>
