import React from 'react';
import ReactModal from 'react-modal';

import {Container, ButtonClose, ButtonCloseIcon, Title, Body} from './styles';

export default function Modal(props) {
    ReactModal.setAppElement('#root');    
    return (
        <ReactModal isOpen={props.open} >
            <Container>
                <ButtonClose onClick={() => props.handlerClose()} >
                    <ButtonCloseIcon className="fas fa-times" />
                </ButtonClose>

                {props.children}
            </Container>
        </ReactModal>
    );
};

export { Title, Body};
