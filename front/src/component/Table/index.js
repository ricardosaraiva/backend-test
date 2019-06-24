import React from 'react';

import { THead, TBody, Tr, Th, Td, TButtonIcon, TLinkIcon } from './styles';


export default function Table(props) {
  return (
    <table className="table table-bordered">
        {props.children}
    </table>
  );
}

export {
    THead,
    TBody,
    Tr,
    Th,
    Td,
    TButtonIcon,
    TLinkIcon
}
