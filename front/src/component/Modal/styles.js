import styled from 'styled-components';

export const Container = styled.div`
    position: absolute;
    top: 0;
    left: 0;
`;

export const ButtonClose = styled.button`
  position: absolute;
  right: 10px;
  top: 10px;
  background: red;
  border: none;
  color: #fff;
  padding: 4px 10px;
  border-radius: 3px;
  z-index: 1000;
`;

export const ButtonCloseIcon = styled.i``;

export const Title = styled.h2`
    background: var(--primary-color);
    border-bottom: 1px solid #DDD;
    padding: 10px;
    color: #fff;
`;

export const Body = styled.div`
    padding: 10px;
`;