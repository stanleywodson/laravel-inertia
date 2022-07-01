import React from 'react'
import { Link } from '@inertiajs/inertia-react';

export default function Paginaitor(props) {
    const {meta} = props
    return (
        <nav aria-label="Page navigation example">
        <ul className="pagination justify-content-center">
            { meta.links.map((link, k) => (
                <li key={k} className="page-item">
                    <Link disabled={link.url == null ? true : false} as="button" className={`${link.active && 'bg-default'} ${link.url == null && 'btn bg-gradient-secondary text-white'} page-link`} href={link.url || ''} dangerouslySetInnerHTML={{ __html: link.label }}/>
                </li>
            ))}
        </ul>
    </nav>
    )
}
